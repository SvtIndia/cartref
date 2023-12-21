<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $roles = request()->roles ? json_decode(request()->roles) : [];
        $rows = request()->rows ?? 25;

        if ($rows == 'all') {
            $rows = User::count();
        }
        /* Query Builder */
        $users = User::with('role')
            ->when(isset($status), function ($query) use ($status) {
                $query->where('status', (int)$status);
            })
            ->when(isset($keyword), function ($query) use ($keyword) {
                $query->where(function ($query1) use ($keyword) {
                    $query1->orWhere('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('mobile', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('street_address_1', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('street_address_2', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('pincode', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('city', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('state', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('brand_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('gender', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->when(is_array($roles) && count($roles) > 0, function ($query) use ($roles) {
                $query->whereHas('role', function ($q) use ($roles) {
                    $q->whereIn('name', $roles)
                        ->orWhereIn('id', $roles);
                });
            })
            ->latest()
            ->paginate($rows);

        //Response
        return new ApiResource($users);
    }


//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'name' => ['required'],
//            'slug' => ['required', 'unique:brands']
//        ]);
//
//        $brnad = User::create([
//            'name' => $request->name,
//            'slug' => $request->slug,
//        ]);
//
//        return response()->json(['status' => 'success', 'msg' => $brnad->name . ' Created Successfully']);
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        $brnad = User::findOrFail($id);
//        return new ApiResource($brnad);
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        $request->validate([
//            'slug' => "nullable|unique:product_categories,slug,{$id}"
//        ]);
//        $brand = User::findOrFail($id);
//        $brand->update($request->all());
//
//        $status = 'success';
//        $msg = $brand->name . ' updated successfully';
//
//        if ($request->filled('status')) {
//            if ($request->status) {
//                $status = 'success';
//                $msg = $brand->name . ' Published Successfully';
//            } else {
//                $status = 'warning';
//                $msg = $brand->name . ' Unpublished Successfully';
//            }
//        }
//        return response()->json(['status' => $status, 'msg' => $msg, 'data' => $brand]);
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        $brand = User::findOrFail($id);
//        $brand->deleted_at = Carbon::now();
//        $brand->save();
//        return response()->json(['status' => 'success', 'msg' => $brand->name . ' Deleted Successfully']);
//    }
}
