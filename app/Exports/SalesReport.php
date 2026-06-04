<?php

namespace App\Exports;

use App\Services\SalesService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SalesReport implements FromArray, WithEvents
{
    private array $grouped;

    public function __construct(private string $timeframe)
    {
        $this->grouped = app(SalesService::class)->getMenuSalesByStall($this->timeframe);
    }

    public function array(): array
    {
        $rows = [];

        $rows[] = [$this->getDateRangeLabel(), '', ''];
        $rows[] = ['', '', ''];

        foreach ($this->grouped as $namaStall => $items) {
            $rows[] = [$namaStall, '', ''];
            $rows[] = ['Nama Menu', 'Porsi Terjual', 'Total Pendapatan'];

            $stallTotal = 0;

            foreach ($items as $item) {
                $rows[] = [
                    $item['menu_name'],
                    $item['menu_sales'] . ' porsi',
                    $item['menu_revenue'],
                ];
                $stallTotal += $item['menu_revenue'];
            }

            $rows[] = ['Total Pendapatan Stall', '', $stallTotal];
            $rows[] = ['', '', ''];
        }

        $grandTotal = collect($this->grouped)
            ->flatten(1)
            ->sum('menu_revenue');

        $rows[] = ['TOTAL KESELURUHAN', '', $grandTotal];

        return $rows;
    }

    private function getDateRangeLabel(): string
    {
        $now = now();

        return match($this->timeframe) {
            'today'     => 'Periode: ' . $now->translatedFormat('d F Y'),
            '7d'        => 'Periode: ' . $now->copy()->subDays(6)->translatedFormat('d F Y') . ' – ' . $now->translatedFormat('d F Y'),
            '3d'        => 'Periode: ' . $now->copy()->subDays(29)->translatedFormat('d F Y') . ' – ' . $now->translatedFormat('d F Y'),
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

                $row = 3;

                foreach ($this->grouped as $namaStall => $items) {

                    $sheet->mergeCells("A{$row}:C{$row}");
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
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
                    $sheet->getRowDimension($row)->setRowHeight(28);
                    $row++;

                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF5EDE5'],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                    $row++;

                    $row += count($items);

                    $sheet->mergeCells("A{$row}:B{$row}");
                    $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF0E7D8'],
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                        ],
                    ]);
                    $row += 2;
                }

                $sheet->mergeCells("A{$row}:B{$row}");
                $sheet->getStyle("A{$row}:C{$row}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE0D2BB'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                $sheet->getStyle("C1:C{$totalRows}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp "#,##0');

                $sheet->getColumnDimension('A')->setWidth(35);
                $sheet->getColumnDimension('B')->setWidth(18);
                $sheet->getColumnDimension('C')->setWidth(22);

                $sheet->getHeaderFooter()
                    ->setOddHeader('&C&"Arial,Bold"&14De\'Pallet');
                $sheet->getHeaderFooter()
                    ->setOddFooter('&C&"Arial,Regular"&9De\'Pallet - Laporan Penjualan');

                $sheet->getPageSetup()
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4)
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)
                    ->setFitToPage(true)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

                $sheet->getPageSetup()->setHorizontalCentered(true);

                $sheet->getPageMargins()->setTop(0.75);
                $sheet->getPageMargins()->setBottom(0.75);
                $sheet->getPageMargins()->setLeft(0.7);
                $sheet->getPageMargins()->setRight(0.7);
                $sheet->getPageMargins()->setHeader(0.3);
                $sheet->getPageMargins()->setFooter(0.3);
            },
        ];
    }
}