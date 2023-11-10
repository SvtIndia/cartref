<?php

namespace App\Imports;

use App\Color;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\ProductCategory;
use App\ProductSubcategory;
use App\Size;

class ProductImport implements ToCollection, WithHeadingRow
{
    public $category_id;
    public $sub_category_id;

    /**
    * @param Collection $collection
    */

    public function  __construct($category_id, $sub_category_id)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::whereName($row['name'])->first();
            if(!isset($product)){
                $product = new Product;
            }
            $product->name = $row['name'];
            $product->slug = Str::slug($row['name']);
            $product->description = $row['description'];
            $product->mrp = $row['mrp'];
            $product->offer_price = $row['offer_price'];

            $product->category_id = $this->category_id;
            $product->subcategory_id = $this->sub_category_id;

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
            $product->save();

//            dd($product->colors);
            if(isset($row['available_colours'])){
                $colours = explode(",", $row['available_colours']);
                foreach ($colours as $colour) {
                    $product->colors()->attach(Color::where('name','LIKE','%'.$colour.'%')->first()->id);
                }
            }

            if(isset($row['available_sizes'])){
                $sizes = explode(",", $row['available_sizes']);
                foreach ($sizes as $size) {
                    $product->sizes()->attach(Size::where('name','LIKE','%'.$size.'%')->first()->id);
                }
            }
        }
    }
}
