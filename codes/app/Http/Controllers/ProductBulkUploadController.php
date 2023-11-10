<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\ProductCategory;
use App\ProductSubcategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductBulkUploadController extends Controller
{
    public function uploadPage()
    {
        $categories = ProductCategory::where('status', true)->get();
        $sub_categories = ProductSubcategory::where('status', true)->get();

        return view('vendor.voyager.products.bulk-upload',compact('categories', 'sub_categories'));
    }

    public function upload(Request $request)
    {
        $category = ProductCategory::findOrFail(request()->category_id);
        $sub_category = ProductSubcategory::findOrFail(request()->subcategory_id);

        try {
            Excel::import(new ProductImport($category->id, $sub_category->id), $request->file);

            $response = [
                'message' => 'Products uploaded successfully',
                'alert-type' => 'success',
            ];
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $response = array(
                'message' => 'Oops! Error occurred. Please Try again Later.',
                'alert-type' => 'error'
            );
        }

        return redirect()->back()->with($response);
    }
}
