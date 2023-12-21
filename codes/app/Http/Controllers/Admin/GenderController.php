<?php

namespace App\Http\Controllers\Admin;

use App\Gender;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GenderController extends Controller
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
            $rows = Gender::count();
        }
        /* Query Builder */
        $genders = Gender::when(isset($status), function ($query) use ($status) {
            $query->where('status', (int)$status);
        })
            ->when(isset($keyword), function ($query) use ($keyword) {
                $query->where(function ($query1) use ($keyword) {
                    $query1->orWhere('name', 'LIKE', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate($rows);

        //Response
        return new ApiResource($genders);
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
        ]);

        $gender = Gender::create([
            'name' => $request->name,
        ]);

        return response()->json(['status' => 'success', 'msg' => $gender->name . ' Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gender = Gender::findOrFail($id);
        return new ApiResource($gender);
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
            'name' => "nullable|unique:genders,name,{$id}"
        ]);
        $gender = Gender::findOrFail($id);
        $gender->update($request->all());

        $status = 'success';
        $msg = $gender->name . ' updated successfully';

        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $gender->name . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $gender->name . ' Unpublished Successfully';
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg, 'data' => $gender]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gender = Gender::findOrFail($id);
        $gender->deleted_at = Carbon::now();
        $gender->save();
        return response()->json(['status' => 'success', 'msg' => $gender->name . ' Deleted Successfully']);
    }
}
