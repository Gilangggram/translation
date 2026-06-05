<?php

namespace App\Exports;

use App\Models\OrderItem;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class StallSalesReport implements FromArray, WithEvents
{
    public function __construct(private int $stallId, private string $stallName, private string $timeframe)
    {
    }

    public function array(): array
    {
        $startDate = match ($this->timeframe) {
            'today' => Carbon::today(),
            '7d'    => Carbon::now()->subDays(6)->startOfDay(),
            '30d'   => Carbon::now()->subDays(29)->startOfDay(),
            '12m'   => Carbon::now()->subMonths(11)->startOfMonth(),
            default => Carbon::now()->subDays(6)->startOfDay(),
        };

        // Query top seller menus
        $topMenus = OrderItem::select('order_items.menu_id', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.total_price) as total_rev'))
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.menu_id')
            ->where('menus.stall_id', $this->stallId)
            ->where('orders.payment_status', 'paid')
            ->where('orders.created_at', '>=', $startDate)
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_qty')
            ->with('menu')
            ->get();

        $rows = [];
        $rows[] = [$this->getDateRangeLabel(), '', ''];
        $rows[] = ['', '', ''];
        $rows[] = ['Laporan Stall: ' . $this->stallName, '', ''];
        $rows[] = ['Nama Menu', 'Porsi Terjual', 'Total Pendapatan'];

        $totalRevenue = 0;
        foreach ($topMenus as $item) {
            $menuName = $item->menu ? $item->menu->name : 'Menu tidak aktif';
            $rows[] = [
                $menuName,
                $item->total_qty . ' porsi',
                (float) $item->total_rev,
            ];
            $totalRevenue += (float) $item->total_rev;
        }

        $rows[] = ['Total Pendapatan', '', $totalRevenue];
        return $rows;
    }

    private function getDateRangeLabel(): string
    {
        $now = now();
        return match($this->timeframe) {
            'today'     => 'Periode: ' . $now->translatedFormat('d F Y'),
            '7d'        => 'Periode: ' . $now->copy()->subDays(6)->translatedFormat('d F Y') . ' – ' . $now->translatedFormat('d F Y'),
            '30d'       => 'Periode: ' . $now->copy()->subDays(29)->translatedFormat('d F Y') . ' – ' . $now->translatedFormat('d F Y'),
            '12m'       => 'Periode: ' . $now->copy()->subMonths(11)->translatedFormat('F Y') . ' – ' . $now->translatedFormat('F Y'),
            default     => 'Periode: ' . $now->translatedFormat('d F Y'),
        };
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $totalRows = $sheet->getHighestRow();

                // Merge date label
                $sheet->mergeCells('A1:C1');
                $sheet->getStyle('A1:C1')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size'   => 10,
                        'color'  => ['argb' => 'FF80543F'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(20);

                // Merge Stall Title
                $sheet->mergeCells('A3:C3');
                $sheet->getStyle('A3:C3')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 12,
                        'color' => ['argb' => 'FFFAF4EC'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF3B1A0D'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(3)->setRowHeight(28);

                // Table Headers
                $sheet->getStyle('A4:C4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF5EDE5'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Total Row
                $sheet->mergeCells("A{$totalRows}:B{$totalRows}");
                $sheet->getStyle("A{$totalRows}:C{$totalRows}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE0D2BB'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle("C5:C{$totalRows}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp "#,##0');

                $sheet->getColumnDimension('A')->setWidth(35);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(22);

                $sheet->getHeaderFooter()
                    ->setOddHeader('&C&"Arial,Bold"&14De\'Pallet');
                $sheet->getHeaderFooter()
                    ->setOddFooter('&C&"Arial,Regular"&9De\'Pallet - Laporan Penjualan Stall');
            },
        ];
    }
}
