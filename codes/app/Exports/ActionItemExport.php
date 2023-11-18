<?php

namespace App\Exports;

use App\Brand;
use App\Color;
use App\Gender;
use App\Size;
use App\Style;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ActionItemExport implements FromCollection, WithHeadings, WithStyles
{
    public $brands;
    public $sizes;
    public $colors;
    public $genders;
    public $styles;

    public function __construct()
    {
        $this->brands = Brand::where('status', 1)->take(25)->get()->pluck('name');
        $this->sizes = Size::where('status', 1)->take(25)->get()->pluck('name');
        $this->colors = Color::where('status', 1)->take(25)->get()->pluck('name');
        $this->genders = Gender::where('status', 1)->take(25)->get()->pluck('name');
        $this->styles = Style::where('status', 1)->take(25)->get()->pluck('name');

    }

    public function collection()
    {
        return collect([
            // Add more data as needed
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
            'Length (cms)',
            'Breadth (cms)',
            'Height (cms)',
            'Weight (Kgs)',
        ];
    }


    public function styles(Worksheet $sheet)
    {

        $columns = [
            (object)['address' => 'F2:1000', 'list' => json_decode(json_encode($this->brands))],
            (object)['address' => 'H2:1000', 'list' => json_decode(json_encode($this->colors))],
            (object)['address' => 'I2:1000', 'list' => json_decode(json_encode($this->sizes))],
            (object)['address' => 'J2:1000', 'list' => json_decode(json_encode($this->styles))],
            (object)['address' => 'K2:1000', 'list' => json_decode(json_encode($this->genders))],
        ];
//        dd($this->brands->toArray());
        $options1 = json_decode(json_encode($this->brands));
        $options2 = json_decode(json_encode($this->colors));
        $options3 = json_decode(json_encode($this->sizes));
        $options4 = json_decode(json_encode($this->styles));
        $options5 = json_decode(json_encode($this->genders));
//        foreach ($columns as $column) {
        $sheet->getDataValidation('E2:E1000')->setType('list')
            ->setFormula1(sprintf('"%s"',implode(',',$options1)))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select a value')
            ->setPrompt('Choose a value from the list.');
        $sheet->getDataValidation('G2:G1000')->setType('list')
            ->setFormula1(sprintf('"%s"',implode(',',$options2)))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select a value')
            ->setPrompt('Choose a value from the list.');
        $sheet->getDataValidation('H2:H1000')->setType('list')
            ->setFormula1(sprintf('"%s"',implode(',',$options3)))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select a value')
            ->setPrompt('Choose a value from the list.');
        $sheet->getDataValidation('I2:I1000')->setType('list')
            ->setFormula1(sprintf('"%s"',implode(',',$options4)))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select a value')
            ->setPrompt('Choose a value from the list.');
        $sheet->getDataValidation('J2:J1000')->setType('list')
            ->setFormula1(sprintf('"%s"',implode(',',$options5)))
            ->setFormula2(null)
            ->setAllowBlank(false)
            ->setShowDropDown(true)
            ->setShowInputMessage(true)
            ->setErrorTitle('Invalid Selection')
            ->setError('Please select a valid option from the list.')
            ->setPromptTitle('Select a value')
            ->setPrompt('Choose a value from the list.');

    }

}