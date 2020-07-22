<?php

namespace App\Http\Controllers;

use App\Peserta;
use App\Rapat;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($_POST['id_rapat'])){
        $id=$_POST['id_rapat'];
    }else{
        return redirect()->back();
    }

        $peserta = Peserta::where("id_rapat",$id)->get();

        if ($request->ajax()) {
            return Datatables::of($peserta)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editpeserta"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Delete" class="btn btn-danger btn-xs deletepeserta"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $rapat=DB::table('rapat')
                    ->join('jenis','jenis.id_jenis','=','rapat.id_jenis')
                    ->join('tempat','tempat.id_tempat','=','rapat.id_tempat')
                    ->where('rapat.id_rapat','=',$id)
                    ->get();
        return view('peserta.data_peserta', compact(array('peserta','rapat')));
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
            'divisi' => $request->divisi,
            'jabatan' => $request->jabatan,
            'hp' => $request->hp,
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

    public function proses_kehadiran(){
        $id_peserta=$_POST['id_peserta'];
        $status_hadir=$_POST['status_hadir'];
        $update = Peserta::where('id_peserta',$id_peserta)
         ->update([
            'status_hadir' => $status_hadir,
          ]);
        if ($update){
         $response = [
            'success' => true,
            'message' => 'Berhasil Diperbaharui.',
        ];
        return response()->json($response, 200);
        }else{
        $response = [
            'success' => false,
            'message' => 'Gagal Diperbaharui',
        ];
        return response()->json($response, 500);
    }
    }
}
