<?php

namespace App\Imports;

use App\Color;
use App\Models\Product;
use App\Size;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements ToCollection, WithMultipleSheets, WithValidation
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

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function rules(): array
    {
        return [
            '0' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '0.required' => 'Product title is required.',
        ];
    }
    public function collection(Collection $collection)
    {
        $rows = $collection->toArray();
        array_shift($rows);
        $rows = json_decode(json_encode($rows));

        foreach ($rows as $index => $row) {
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
                $colours = explode(",", trim($row[6]));
                foreach ($colours as $colour) {
                    $colour = trim($colour);
                    $item = Color::where('status', 1)->where('name', 'LIKE', '%' . $colour . '%')->first();
                    if (isset($item)) {
                        $product->colors()->attach($item->id);
                    }
                }
            }
            //sizes
            if (isset($row[7])) {
                $sizes = explode(",", trim($row[7]));
                foreach ($sizes as $size) {
                    $size = trim($size);
                    $item = Size::where('status', 1)->where('name', 'LIKE', '%' . $size . '%')->first();
                    if (isset($item)) {
                        $product->sizes()->attach($item->id);
                    }
                }
            }
        }
    }

}
