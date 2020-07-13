<?php

namespace App\Http\Controllers;

use App\Peserta;
use Illuminate\Http\Request;
use DataTables;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id=null)
    {
        $peserta = Peserta::where("id_rapat",$id)->get();

        if ($request->ajax()) {
            return Datatables::of($peserta)
                ->addIndexColumn()
                ->addColumn('status_hadir',function ($row){
                    if ($row->status_peserta==1){
                        return "Hadir";
                    }elseif($row->status_peserta==2){
                        return "Tidak Hadir";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editpeserta">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Delete" class="btn btn-danger btn-sm deletepeserta">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['status_hadir','action'])
                ->make(true);
        }
        $id_rapat=$id;
        return view('peserta.data_peserta', compact(array('peserta','id_rapat')));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        peserta::updateOrCreate([
            'id_peserta' => $request->id_peserta
        ],[
            'id_rapat' => $request->id_rapat,
            'nama_peserta' => $request->nama_peserta,
            'jabatan' => $request->jabatan,
            'status_hadir' => "0",
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Peserta saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\peserta $peserta
     * @return \Illuminate\Http\Response
     */
    public function edit($id_peserta)
    {
        $peserta = Peserta::find($id_peserta);
        return response()->json($peserta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_peserta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Peserta::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'peserta deleted successfully.',
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
