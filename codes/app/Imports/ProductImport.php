<?php

namespace App\Imports;

use App\Brand;
use App\Color;
use App\Gender;
use App\Models\Product;
use App\Size;
use App\Style;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImport implements ToCollection
{
    public $category_id;
    public $sub_category_id;

    /**
     * @param Collection $collection
     */

    public $brands;
    public $sizes;
    public $colors;
    public $genders;
    public $styles;

    public function __construct($category_id, $sub_category_id)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
    }

    public function collection(Collection $rows)
    {
        unset($rows[0]);
        foreach ($rows as $row) {
//            dd($row['5']);
            $product = Product::whereName($row[0])->first();
            if (!isset($product)) {
                $product = new Product;
            }
            $product->name = $row[0];
            $product->slug = Str::slug($row[0]);
            $product->description = $row[1];
            $product->mrp = (float)($row[2]);
            $product->offer_price = (float)($row[3]);

            $product->category_id = $this->category_id;
            $product->subcategory_id = $this->sub_category_id;

            $product->brand_id = $row[4];
            $product->sku = $row[5];

            //6 => colors
            //7 => sizes

            $product->style_id = $row[8];
            $product->gender_id = $row[9];

            $product->length = $row[10];
            $product->breadth = $row[11];
            $product->height = $row[12];
            $product->weight = $row[13];

            $product->created_by = auth()->user()->id;
            $product->seller_id = auth()->user()->id;
            $product->save();

            //colors
            if (isset($row[6])) {
                $colours = explode(",", preg_replace('/\s+/', '', $row[6]));
                foreach ($colours as $colour) {
                    $item = Color::where('name', 'LIKE', '%' . $colour . '%')->first();
                    if(isset($item)){
                        $product->colors()->attach($item->id);
                    }
                }
            }
            //sizes
            if (isset($row[7])) {
                $sizes = explode(",", preg_replace('/\s+/', '', $row[7]));
                foreach ($sizes as $size) {
                    $item = Size::where('name', 'LIKE', '%' . $size . '%')->first();
                    if(isset($item)){
                        $product->sizes()->attach($item->id);
                    }
                }
            }
        }
    }

}
