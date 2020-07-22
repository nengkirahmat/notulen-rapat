<?php

namespace App\Http\Controllers;
use App\Notulen;
use App\Rapat;
use App\Jenis;
use App\Tempat;
use App\Peserta;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class NotulenController extends Controller
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
                ->orWhereNull("rapat.deleted_at")
                ->where("status_rapat","2")
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
                        return "Berlangsung";
                    }elseif($row->status_rapat==3){
                        return "Selesai";
                    }elseif ($row->status_rapat==4) {
                        return "Dibatalkan";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-judul="'.$row->judul_rapat.'" data-status_rapat="'.$row->status_rapat.'" data-original-title="Ubah Status" class="edit btn btn-warning btn-xs editstatus"><i class="fa fa-paper-plane-o"></i> Ubah Status</a>';

                    $btn = $btn . ' <form action="peserta/tambah" method="post">'.csrf_field().'<input type="hidden" name="id_rapat" value="'.$row->id_rapat.'"><button type="submit" class="btn btn-info btn-xs"><i class="fa fa-user-circle"></i> Peserta</button></form>';

                    return $btn;
                })
                ->rawColumns(['tgl_rapat','waktu_rapat','status_rapat','action'])
                ->make(true);
        }
        $jenis=Jenis::All();
        $tempat=Tempat::All();
        return view('notulen.data_notulen', compact(array('rapat','jenis','tempat')));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Notulen::updateOrCreate([
            'id_notulen' => $request->id_notulen
        ],[
            'id_rapat' => $request->id_rapat,
            'id_user' => 1,
            'isi_rapat' => $request->isi_rapat,
            'status_notulen' => $request->status_notulen,
            ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Notulen saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\notulen $notulen
     * @return \Illuminate\Http\Response
     */
    public function edit($id_notulen)
    {
        $notulen = Notulen::find($id_notulen);
        return response()->json($notulen);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_notulen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $del=Notulen::destroy($id);
        dd($del);
        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'Notulen deleted successfully.',
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

    public function proses(Request $request)
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
                ->addColumn('status_hadir',function ($row){
                    if ($row->status_hadir==1){
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='1' data-id='".$row->id_peserta."' checked='true'> Hadir";
                    }elseif($row->status_hadir==2){
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='2' data-id='".$row->id_peserta."'> Tidak Hadir";
                    }else{
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='0' data-id='".$row->id_peserta."'> Belum Absen";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editpeserta"><i class="fa fa-pencil"></i> Ubah</a>';

                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Delete" class="btn btn-danger btn-xs deletepeserta"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['status_hadir','action'])
                ->make(true);
        }
        $rapat=DB::table('rapat')
                    ->join('jenis','jenis.id_jenis','=','rapat.id_jenis')
                    ->join('tempat','tempat.id_tempat','=','rapat.id_tempat')
                    ->where('rapat.id_rapat','=',$id)
                    ->get();
        return view('notulen.data_proses', compact(array('peserta','rapat')));
    }

}
