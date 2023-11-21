<?php

namespace App\Http\Controllers;

use App\Exports\ActionItemExport;
use App\Imports\ProductImport;
use App\ProductCategory;
use App\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProductBulkUploadController extends Controller
{
    public function uploadPage()
    {
        $categories = ProductCategory::with('subcategory')->where('status', true)->get();
        return view('vendor.voyager.products.bulk-upload', compact('categories'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ]);
        $category = ProductCategory::findOrFail(request()->category_id);
        $sub_category = ProductSubcategory::findOrFail(request()->subcategory_id);

        try {
            $imp = Excel::import(new ProductImport($category->id, $sub_category->id), $request->file);

            $response = [
                'message' => 'Products uploaded successfully',
                'alert-type' => 'success',
            ];
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $all_errors = $e->errors();
            Log::error($failures);
            Log::error($all_errors);
            Log::error($e);
            $errormessage = "";

            foreach ($failures as $failure) {
                $errormess = "";
                foreach ($failure->errors() as $error) {
                    $errormess = $errormess . $error;
                }
                if (isset($errormessage)){
                    $errormessage .= " ,\n";
                }
                $errormessage = $errormessage . " At Row " . $failure->row() . ", " . $errormess . "<br>";
            }

            $response = [
                'message' => 'Some Error Occurred',
                'alert-type' => 'error',
            ];
            Session::flash('upload-error', $errormessage);
        }

        return redirect()->back()->with($response);
    }

    public function export_product_dummy()
    {
        return Excel::download(
            new ActionItemExport(),
            'CARTREFS PRODUCT-UPLOAD.xlsx'
        );
    }
}
