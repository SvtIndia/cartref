<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Query Parameters */
        $keyword = request()->keyword;
        $status = request()->status;
        $rows = request()->rows ?? 25;

        if ($rows == 'all') {
            $rows = Brand::count();
        }
        /* Query Builder */
        $brands = Brand::when(isset($status), function ($query) use ($status) {
            $query->where('status', (int)$status);
        })
            ->when(isset($keyword), function ($query) use ($keyword) {
                $query->where(function ($query1) use ($keyword) {
                    $query1->orWhere('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('slug', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate($rows);

        //Response
        return new ApiResource($brands);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'slug' => ['required', 'unique:brands']
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json(['status' => 'success', 'msg' => $brand->name . ' Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return new ApiResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'slug' => "nullable|unique:brands,slug,{$id}"
        ]);
        $brand = Brand::findOrFail($id);
        $brand->update($request->all());

        $status = 'success';
        $msg = $brand->name . ' updated successfully';

        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $brand->name . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $brand->name . ' Unpublished Successfully';
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg, 'data' => $brand]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->deleted_at = Carbon::now();
        $brand->save();
        return response()->json(['status' => 'success', 'msg' => $brand->name . ' Deleted Successfully']);
    }
}
