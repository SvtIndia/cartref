<?php

namespace App\Http\Controllers\Admin;

use App\Color;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Product;
use App\Productcolor;
use App\Productsku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                        ->orWhere('style_id', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate($rows);

        //Response
        return new ApiResource($products);
    }

    public function fetchProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id)->append('json_images');
        //Response
        return new ApiResource($product);
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

    public function fetchProductColor(Request $request, $id)
    {
        $color = Productcolor::findOrFail($id)->append('json_more_images');
        //Response
        return new ApiResource($color);
    }

    public function updateProductColorStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required'],
        ]);
        $status = $request->status;

        $productColor = Productcolor::findOrFail($id);
        $product = Product::findOrFail($productColor->product_id);
        $targetColor = Color::where('name', $productColor->color)->first();

        if ($status) {
//            dd($targetColor);
            $product->colors()->attach($targetColor);
        } else {
            $product->colors()->detach($targetColor);
        }
        $productColor->update(['status' => $status]);

        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $targetColor->name . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $targetColor->name . ' Unpublished Successfully';
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg]);

    }

    public function deleteImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required'
        ]);
        $image = $request->image;
        $productColor = Productcolor::findOrFail($id)->append('json_more_images');
        $json_images = $productColor->json_more_images;

        if (in_array($image, $json_images)) {
            $filePath = Storage::path('public/' . $image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $key = array_search($image, $json_images);
//            unset($json_images[$key]);
            array_splice($json_images, $key, 1);
            $productColor->update(['more_images' => json_encode($json_images)]);
            return response()->json(['status' => 'success', 'msg' => 'Image deleted successfully']);
        }

        return response()->json(['status' => 'warning', 'msg' => 'Image not found']);
    }

    public function uploadImages(Request $request, $id)
    {
        $request->validate([
            'images' => 'required'
        ]);

        $files = $request->file('images');
        $productColor = Productcolor::findOrFail($id)->append('json_more_images');
        $json_images = $productColor->json_more_images;

        foreach ($files as $file) {
            $filName = Str::random() . '.' . $file->getClientOriginalExtension();
            $subFolder = date('FY');
            $destinationPath = Storage::path('public/productcolors/' . $subFolder);
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            if ($file->move($destinationPath, $filName)) {
                //file moved and push to array
                $dbPath = 'productcolors/' . $subFolder . '/' . $filName;
                array_push($json_images, $dbPath);
            }
        }
        $productColor->update(['more_images' => json_encode($json_images)]);
        return response()->json(['status' => 'success', 'msg' => 'Images uploaded successfully']);

    }

    public function uploadMainImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);
        $productColor = Productcolor::findOrFail($id);

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filName = Str::random() . '.' . $file->getClientOriginalExtension();
            $subFolder = date('FY');
            $destinationPath = Storage::path('public/productcolors/' . $subFolder);

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            if ($file->move($destinationPath, $filName)) {
                //file moved
                $dbPath = 'productcolors/' . $subFolder . '/' . $filName;

                //deleting existing file
                $oldFilePath = Storage::path('public/' . $productColor->main_image);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }

                //replace string with new one
                $productColor->update(['main_image' => $dbPath]);
                return response()->json(['status' => 'success', 'msg' => 'Image updated successfully']);
            }
        }

        return response()->json(['status' => 'error', 'msg' => 'Something went wrong']);
    }

    public function fetchSizesByColorId(Request $request, $product_id, $color_id)
    {
        $productColor = Productcolor::findOrFail($color_id);
        $sizes = Productsku::where([
            'product_id' => $product_id,
            'color' => $productColor->color,
        ])
            ->orderBy('size', 'ASC')->get();
        return new ApiResource($sizes);
    }

    public function fetchSizeById(Request $request, $product_id, $color_id, $size_id)
    {
        $productColor = Productcolor::findOrFail($color_id);
        $size = Productsku::where([
            'id' => $size_id,
            'product_id' => $product_id,
            'color' => $productColor->color,
        ])
            ->firstOrFail();

        return new ApiResource($size);
    }

    public function updateSizeById(Request $request, $product_id, $color_id, $size_id)
    {
        $productColor = Productcolor::findOrFail($color_id);
        $size = Productsku::where([
            'id' => $size_id,
            'product_id' => $product_id,
            'color' => $productColor->color,
        ])
            ->firstOrFail();

        $size->update($request->all());
        $status = 'success';

        $msg = $size->size . ' updated successfully';
        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $size->size . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $size->size . ' Unpublished Successfully';
            }
        }

        return response()->json(['status' => $status, 'msg' => $msg]);
    }

}
