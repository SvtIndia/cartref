<?php
// app/Exports/Sheet1Export.php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Sheet1Export implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    public $brands;
    public $sizes;
    public $colors;
    public $genders;
    public $styles;
    public function __construct($brands = [], $sizes = [], $colors = [], $genders = [], $styles = []){
        $this->brands = $brands;
        $this->sizes = $sizes;
        $this->colors = $colors;
        $this->genders = $genders;
        $this->styles = $styles;
    }

    public function collection()
    {
        return collect([

        ]);
    }
    public function headings(): array
    {
        // Specify column headings
        return [
            'Product Title',
            'Description',
            'MRP',
            'Offer Price',
            'Brand Name',
            'SKU ID',
            'Colors',
            'Available Sizes',
            'Style',
            'Gender',
            "Length \n (cms)",
            "Breadth \n (cms)",
            "Height \n (cms)",
            "Weight \n (Kgs)",
            "Features",
            "Product Keywords \n Comma (,) Seperated",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDataValidation('E2:E1000')->setType('list')
            ->setFormula1(sprintf("='Worksheet 1'!\$A$2:\$A$%s", count($this->brands) + 1))
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid brand from the list.')
            ->setPromptTitle('Select a brand')
            ->setPrompt('Choose a brand from the list.');

        $sheet->getDataValidation('G2:G1000')->setType('list')
            ->setFormula1(sprintf("='Worksheet 1'!\$C$2:\$C$%s", count($this->colors) + 1))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select color(s)')
            ->setPrompt(sprintf("For multiple colors use comma(,) seperated.\nView all colors: Refer Worksheet1"));

        $sheet->getDataValidation('H2:H1000')->setType('list')
            ->setFormula1(sprintf("='Worksheet 1'!\$B$2:\$B$%s", count($this->sizes) + 1))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select Size(s)')
            ->setPrompt(sprintf("For multiple sizes use comma(,) seperated.\nView all sizes: Refer Worksheet1"));

        $sheet->getDataValidation('I2:I1000')->setType('list')
            ->setFormula1(sprintf("='Worksheet 1'!\$E$2:\$E$%s", count($this->styles) + 1))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid Style from the list.')
            ->setPromptTitle('Select Style')
            ->setPrompt('Choose a Style from the list.');

        $sheet->getDataValidation('J2:J1000')
            ->setType('list')
            ->setErrorStyle(DataValidation::STYLE_INFORMATION )
            ->setFormula1(sprintf("='Worksheet 1'!\$D$2:\$D$%s", count($this->genders) + 1))
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid gender from the list.')
            ->setPromptTitle('Select Gender')
            ->setPrompt('Choose a gender from the list.');

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Autoresize the first row
                $event->sheet->autoSize();
                // Set alignment for the first row (center horizontally and vertically)
                $event->sheet->getStyle('1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getStyle('1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                // Wrap text for the first row
                $event->sheet->getStyle('1')->getAlignment()->setWrapText(true);
            },
        ];
    }
}