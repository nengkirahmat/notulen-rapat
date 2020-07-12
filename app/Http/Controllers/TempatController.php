<?php

namespace App\Http\Controllers;

use App\Tempat;
use Illuminate\Http\Request;
use DataTables;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tempat = Tempat::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($tempat)
                ->addIndexColumn()
                ->addColumn('status_tempat',function ($row){
                    if ($row->status_tempat==1){
                        return "Aktif";
                    }elseif($row->status_tempat==2){
                        return "Non Aktif";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_tempat="' . $row->id_tempat . '" data-original-title="Edit" class="edit btn btn-primary btn-sm edittempat">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_tempat="' . $row->id_tempat . '" data-original-title="Delete" class="btn btn-danger btn-sm deletetempat">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['status_tempat','action'])
                ->make(true);
        }

        return view('tempat.data_tempat', compact('tempat'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        tempat::updateOrCreate([
            'id_tempat' => $request->id_tempat
        ],[
            'nama_tempat' => $request->nama_tempat,
            'status_tempat' => $request->status_tempat,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Tempat saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\tempat $tempat
     * @return \Illuminate\Http\Response
     */
    public function edit($id_tempat)
    {
        $tempat = Tempat::find($id_tempat);
        return response()->json($tempat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_tempat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Tempat::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'tempat deleted successfully.',
        ];
        return response()->json($response, 200);
    }else{
        $response = [
            'success' => false,
            'message' => 'Gagal Hapus Data',
        ];
        return response()->json($response, 500);
    }
    }
}
