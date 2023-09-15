<?php

namespace App\Imports;

use App\Color;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use App\Size;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function  __construct()
    {

    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::whereName($row['name'])->first();
            if(!isset($product)){
                $product = new Product;
            }
            $product->name = $row['name'];
            $product->slug = $row['slug'];
            $product->description = $row['description'];
            $product->mrp = $row['mrp'];
            $product->offer_price = $row['offer_price'];
            $product->subcategory_id = ProductSubcategory::whereName($row['subcategory_id'])->first()->id;
            $product->brand_id = $row['brand_id'];
            $product->style_id = $row['style_id'];
            $product->gender_id = $row['gender_id'];
            $product->length = $row['length'];
            $product->breadth = $row['breadth'];
            $product->height = $row['height'];
            $product->weight = $row['weight'];
            $product->created_by = auth()->user()->id;
            $product->seller_id = auth()->user()->id;
            $product->features = $row['features'];
            $product->sku = $row['sku'];
            $product->category_id = ProductCategory::whereName($row['category_id'])->first()->id;

            $product->save();

            if(isset($row['available_colours'])){
                $colours = explode(",", $row['available_colours']);
                foreach ($colours as $colour) {
                    $product->available_colours()->attach(Color::whereName($colour)->first());
                }
            }

            if(isset($row['available_sizes'])){
                $sizes = explode(",", $row['available_sizes']);
                foreach ($sizes as $size) {
                    $product->available_sizes()->attach(Size::whereName($size)->first());
                }
            }
        }
    }
}
