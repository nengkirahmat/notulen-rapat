<?php

namespace App\Http\Controllers;

use App\Rapat;
use App\Jenis;
use App\Tempat;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rapat = DB::table('rapat')
                ->join('jenis', 'jenis.id_jenis', '=', 'rapat.id_jenis')
                ->join('tempat', 'tempat.id_tempat', '=', 'rapat.id_tempat')
                ->get();
        if ($request->ajax()) {
            return Datatables::of($rapat)
                ->addIndexColumn()
                ->addColumn('tgl_rapat',function ($row){
                    return $row->hari." / ".date('d F Y',strtotime($row->tgl_rapat));

                })
                ->addColumn('waktu_rapat',function ($row){
                    $akhir="";
                    if ($row->jam_akhir=="00:00"){
                        $akhir="Selesai";
                    }else{
                        $akhir=$row->jam_akhir;
                    }
                    return "Jam ".$row->jam_mulai." s/d ".$akhir;
                })
                ->addColumn('status_rapat',function ($row){
                    if ($row->status_rapat==1){
                        return "Belum Mulai";
                    }elseif($row->status_rapat==2){
                        return "Proses";
                    }elseif($row->status_rapat==3){
                        return "Selesai";
                    }elseif ($row->status_rapat==4) {
                        return "Dibatalkan";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editrapat">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-original-title="Delete" class="btn btn-danger btn-sm deleterapat">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['tgl_rapat','waktu_rapat','status_rapat','action'])
                ->make(true);
        }
        $jenis=Jenis::All();
        $tempat=Tempat::All();
        return view('rapat.data_rapat', compact(array('rapat','jenis','tempat')));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        rapat::updateOrCreate([
            'id_rapat' => $request->id_rapat
        ],[
            'id_jenis' => $request->id_jenis,
            'id_tempat' => $request->id_tempat,
            'judul_rapat' => $request->judul_rapat,
            'hari' => $request->hari,
            'tgl_rapat' => $request->tgl_rapat,
            'jam_mulai' => $request->jam_mulai,
            'jam_akhir' => $request->jam_akhir,
            'pimpinan_rapat' => $request->pimpinan_rapat,
            'sifat_rapat' => $request->sifat_rapat,
            'status_rapat' => $request->status_rapat,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Rapat saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\rapat $rapat
     * @return \Illuminate\Http\Response
     */
    public function edit($id_rapat)
    {
        $rapat = Rapat::find($id_rapat);
        return response()->json($rapat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_rapat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Rapat::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'rapat deleted successfully.',
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
