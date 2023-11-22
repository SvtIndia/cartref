<?php

namespace App\Exports;

use App\Brand;
use App\Color;
use App\Gender;
use App\Size;
use App\Style;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ActionItemExport implements WithMultipleSheets
{
    use Exportable;

    public $brands;
    public $sizes;
    public $colors;
    public $genders;
    public $styles;
    public function __construct()
    {
        $this->brands = Brand::where('status', 1)->get()->pluck('name');
        $this->sizes = Size::where('status', 1)->get()->pluck('name');
        $this->colors = Color::where('status', 1)->get()->pluck('name');
        $this->genders = Gender::where('status', 1)->get()->pluck('name');
        $this->styles = Style::where('status', 1)->get()->pluck('name');

    }
    public function sheets(): array
    {
        $sheets = [];

        //Main Content
        $sheets[] = new Sheet1Export(
            $this->brands,
            $this->sizes,
            $this->colors,
            $this->genders,
            $this->styles
        );

        //display brands, sizes, colors etc.
        $sheets[] = new Sheet2Export(
            $this->brands,
            $this->sizes,
            $this->colors,
            $this->genders,
            $this->styles
        );

        return $sheets;
    }
}