<?php
// app/Exports/Sheet1Export.php

namespace App\Exports;

use App\Brand;
use App\Color;
use App\Gender;
use App\Size;
use App\Style;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Sheet2Export implements FromCollection, WithHeadings, WithStyles
{
    public $data;
    public function __construct($brands = [], $sizes = [], $colors = [], $genders = [], $styles = [])
    {

        $this->data = array_map(null,
            $brands->toArray(),
            $sizes->toArray(),
            $colors->toArray(),
            $genders->toArray(),
            $styles->toArray(),
        );
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        // Use the keys (original row headers) as headings
        return [
            'Brands',
            'Sizes',
            'Colors',
            'Genders',
            'Styles',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        return [
            // Style the first row as bold text and font-size.
            1    => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set alignment for the first row (center horizontally and vertically)
                $event->sheet->getStyle('1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}