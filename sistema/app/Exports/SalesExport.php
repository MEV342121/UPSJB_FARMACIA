<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Exporta a Excel las ventas que ya vienen filtradas desde ReportController
class SalesExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithEvents, ShouldAutoSize
{
    public function __construct(private Collection $sales)
    {
    }

    public function collection(): Collection
    {
        return $this->sales;
    }

    public function headings(): array
    {
        return ['N.°', 'Fecha', 'Cliente', 'Vendedor', 'IGV (S/)', 'Total (S/)'];
    }

    // Convierte cada venta en una fila
    public function map($sale): array
    {
        return [
            str_pad($sale->id, 6, '0', STR_PAD_LEFT),
            $sale->date->format('d/m/Y H:i'),
            $sale->customer->name,
            $sale->user->name,
            (float) $sale->igv,
            (float) $sale->total,
        ];
    }

    public function title(): string
    {
        return 'Ventas';
    }

    // Encabezado en negrita
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }

    // Fila final con los totales
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $row = $this->sales->count() + 2;

                $sheet->setCellValue("D{$row}", 'TOTALES');
                $sheet->setCellValue("E{$row}", (float) $this->sales->sum('igv'));
                $sheet->setCellValue("F{$row}", (float) $this->sales->sum('total'));
                $sheet->getStyle("D{$row}:F{$row}")->getFont()->setBold(true);
            },
        ];
    }
}
