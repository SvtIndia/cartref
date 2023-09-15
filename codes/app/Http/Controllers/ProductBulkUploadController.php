<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductBulkUploadController extends Controller
{
    public function uploadPage(){
        return view('vendor.voyager.products.bulk-upload');
    }

    public function upload(){

    }
}
