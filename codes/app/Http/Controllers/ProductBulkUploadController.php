<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductBulkUploadController extends Controller
{
    public function uploadPage()
    {
        return view('vendor.voyager.products.bulk-upload');
    }

    public function upload(Request $request)
    {
        try {
            Excel::import(new ProductImport(), $request->file);

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
