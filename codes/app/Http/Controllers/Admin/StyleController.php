<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Style;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StyleController extends Controller
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
            $rows = Style::count();
        }
        /* Query Builder */
        $styles = Style::when(isset($status), function ($query) use ($status) {
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
        return new ApiResource($styles);
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
            'slug' => ['required', 'unique:styles']
        ]);

        $style = Style::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return response()->json(['status' => 'success', 'msg' => $style->name . ' Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $style = Style::findOrFail($id);
        return new ApiResource($style);
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
            'slug' => "nullable|unique:styles,slug,{$id}"
        ]);
        $style = Style::findOrFail($id);
        $style->update($request->all());

        $status = 'success';
        $msg = $style->name . ' updated successfully';

        if ($request->filled('status')) {
            if ($request->status) {
                $status = 'success';
                $msg = $style->name . ' Published Successfully';
            } else {
                $status = 'warning';
                $msg = $style->name . ' Unpublished Successfully';
            }
        }
        return response()->json(['status' => $status, 'msg' => $msg, 'data' => $style]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $style = Style::findOrFail($id);
        $style->deleted_at = Carbon::now();
        $style->save();
        return response()->json(['status' => 'success', 'msg' => $style->name . ' Deleted Successfully']);
    }
}
