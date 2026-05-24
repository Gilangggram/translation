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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet     = $event->sheet->getDelegate();
                $totalRows = $sheet->getHighestRow();
                $row       = 1;

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
            },
        ];
    }
}