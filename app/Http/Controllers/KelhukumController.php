<?php

namespace App\Http\Controllers;

use App\Kelhukum;
use Illuminate\Http\Request;
use DataTables;

class KelhukumController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kel = Kelhukum::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($kel)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_kel="' . $row->id_kel . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editkelompok"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_kel="' . $row->id_kel . '" data-original-title="Delete" class="btn btn-danger btn-xs deletekelompok"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('kelhukum.data_kelhukum', compact('kel'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kelhukum::updateOrCreate([
            'id_kel' => $request->id_kel
        ],[
            'nama_kel' => $request->nama_kel,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Kelompok Hukum saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\kelompok $kelompok
     * @return \Illuminate\Http\Response
     */
    public function edit($id_kel)
    {
        $kel = Kelhukum::find($id_kel);
        return response()->json($kel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_kelompok
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Kelhukum::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'Kelompok Hukum Berhasil Dihapus.',
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
