<?php

namespace App\Http\Controllers;

use App\Jenis;
use Illuminate\Http\Request;
use DataTables;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jenis = Jenis::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($jenis)
                ->addIndexColumn()
                ->addColumn('status_jenis',function ($row){
                    if ($row->status_jenis==1){
                        return "Aktif";
                    }elseif($row->status_jenis==2){
                        return "Non Aktif";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_jenis="' . $row->id_jenis . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editjenis">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_jenis="' . $row->id_jenis . '" data-original-title="Delete" class="btn btn-danger btn-sm deletejenis">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['status_jenis','action'])
                ->make(true);
        }

        return view('jenis.data_jenis', compact('jenis'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        jenis::updateOrCreate([
            'id_jenis' => $request->id_jenis
        ],[
            'nama_jenis' => $request->nama_jenis,
            'status_jenis' => $request->status_jenis,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Jenis saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\jenis $jenis
     * @return \Illuminate\Http\Response
     */
    public function edit($id_jenis)
    {
        $jenis = Jenis::find($id_jenis);
        return response()->json($jenis);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_jenis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Jenis::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'jenis deleted successfully.',
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
