<?php

namespace App\Http\Controllers\Admin;

use App\Color;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Product;
use App\Productcolor;
use App\ProductSubcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function fetchProducts(Request $request)
    {
        /* Query Parameters */
        $keyword = request()->keyword;
        $status = request()->status;
        $parent_category_id = request()->parent_category;
        $sub_category_id = request()->sub_category;
        $seller_id = request()->seller_id;
        $rows = request()->rows ?? 25;

        if ($rows == 'all') {
            $rows = Product::count();
        }
        /* Query Builder */
        $products = Product::with('productcategory', 'productsubcategory')
            ->when(isset($status), function ($query) use ($status) {
                $query->where('admin_status', $status);
            })
            ->when(isset($parent_category_id), function ($query) use ($parent_category_id) {
                $query->where('category_id', $parent_category_id);
            })
            ->when(isset($sub_category_id), function ($query) use ($sub_category_id) {
                $query->where('subcategory_id', $sub_category_id);
            })
            ->when(isset($seller_id), function ($query) use ($seller_id) {
                $query->where('seller_id', $seller_id);
            })
            ->when(isset($keyword), function ($query) use ($keyword) {
                $query->where(function ($query1) use ($keyword) {
                    $query1->orWhere('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('slug', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('sku', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('product_tags', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('brand_id', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('style_id', 'LIKE', '%' . $keyword . '%')
                    ;
                });
            })
            ->latest()
            ->paginate($rows);

        //Response
        return new ApiResource($products);
    }
    public function updateProductStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required'],
        ]);
        $status = $request->status;
        $product = Product::findOrFail($id);
        $product->update(['admin_status' => $status]);

        if ($status == 'Accepted') {
            $status = 'success';
            $msg = 'Product Published Successfully';
        } else {
            $status = 'warning';
            $msg = 'Product Unpublished Successfully';
        }
        //Response
        return new ApiResource(['status' => $status, 'msg' => $msg]);
    }

    public function fetchProductColors(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $colors = Productcolor::where('product_id', $product->id)->get();

        //Response
        return new ApiResource(['colors' => $colors, 'product' => $product]);
    }

    public function updateProductColorStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required'],
        ]);
        $status = $request->status;

        $productColor = Productcolor::findOrFail($id);
        $product = Product::findOrFail($productColor->product_id);
        $targetColor = Color::where('name',$productColor->color)->first();

        if($status){
            $product->colors()->attach($targetColor->id);
        }
        else{
            $product->colors()->detach($targetColor);
        }
        $productColor->update(['status' => $status]);

        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $productColor->name . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $productColor->name . ' Unpublished Successfully';
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg]);

    }
}
