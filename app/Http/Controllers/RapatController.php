<?php

namespace App\Http\Controllers;

use App\Rapat;
use App\Jenis;
use App\Tempat;
use App\Anggotadprd;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class RapatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status="";
        if ($request->status==1){
            $status=1;
        }elseif ($request->status==2) {
            $status=2;
        }elseif ($request->status==3) {
            $status=3;
        }elseif ($request->status==4) {
            $status=4;
        }
        $rapat = DB::table('rapat')
        ->select("rapat.*","jenis.nama_jenis","tempat.nama_tempat","notulen.id_notulen")
        ->join('jenis', 'jenis.id_jenis', '=', 'rapat.id_jenis')
        ->join('tempat', 'tempat.id_tempat', '=', 'rapat.id_tempat')
        ->leftJoin('notulen','notulen.id_rapat','=','rapat.id_rapat')
        ->orWhereNull("rapat.deleted_at")
        ->where("rapat.status_rapat",$status)
        ->latest()
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
                if ($row->status_rapat==1){
                    // $btn ='<form action="notulen/detail" method="post">'.csrf_field().'<input type="hidden" name="id_rapat" value="'.$row->id_rapat.'"><button type="submit" class="btn btn-success btn-xs btn-block"><i class="fa fa-spinner"></i> Proses</button></form>';
                    $btn ='<a href="notulen/detail/'.$row->id_rapat.'" class="btn btn-success btn-xs btn-block"><i class="fa fa-spinner"></i> Proses</a>';
                    $btn = $btn.' <form action="peserta/tambah" method="post">'.csrf_field().'<input type="hidden" name="id_rapat" value="'.$row->id_rapat.'"><button type="submit" class="btn btn-info btn-xs"><i class="fa fa-user-circle"></i> Peserta</button></form>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-original-title="Edit" class="edit btn btn-warning  btn-xs editrapat"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-original-title="Delete" class="btn btn-danger  btn-xs deleterapat"><i class="fa fa-trash"></i> Hapus</a>';
                }elseif($row->status_rapat==2){
                    $btn="";
                    if (!empty($row->id_notulen)){
                        $btn ='<a href="notulen/detail/'.$row->id_rapat.'" class="btn btn-info btn-xs btn-block"><i class="fa fa-check"></i> Sudah Ada Data</a>';    
                    }
                    $btn =$btn.' <a href="notulen/detail/'.$row->id_rapat.'" class="btn btn-success btn-xs btn-block"><i class="fa fa-eye"></i> Lihat Detail</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_rapat="' . $row->id_rapat . '" data-judul="'.$row->judul_rapat.'" data-status_rapat="'.$row->status_rapat.'" data-original-title="Ubah Status" class="edit btn btn-warning btn-xs editstatus"><i class="fa fa-paper-plane-o"></i> Ubah Status</a>';

                    // $btn = $btn . ' <form action="peserta/tambah" method="post">'.csrf_field().'<input type="hidden" name="id_rapat" value="'.$row->id_rapat.'"><button type="submit" class="btn btn-info btn-xs"><i class="fa fa-user-circle"></i> Peserta</button></form>';
                }elseif($row->status_rapat==3){
                    $btn="";
                    if (!empty($row->id_notulen)){
                        $btn ='<a target="_blank" href="printnotulen/'.Crypt::encrypt($row->id_rapat).'" class="btn btn-default btn-xs btn-block"><i class="fa fa-print"></i> Cetak Notulen</a>';    
                    }
                    $btn =$btn.' <a href="notulen/detail/'.$row->id_rapat.'" class="btn btn-success btn-xs btn-block"><i class="fa fa-spinner"></i> Lihat Detail</a>';
                }elseif ($row->status_rapat==4) {
                    $btn="";
                }
                return $btn;
            })
            ->rawColumns(['tgl_rapat','waktu_rapat','status_rapat','action'])
            ->make(true);
        }
        $jenis=Jenis::where('status_jenis','=','1')->get();
        $tempat=Tempat::where('status_tempat','=','1')->get();
        $anggotadprd=Anggotadprd::All();
        return view('rapat.data_rapat', compact(array('rapat','jenis','tempat','anggotadprd')));
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
            'pimpinan_rapat' => $request->nama_pimpinan_rapat,
            'jabatan_pimpinan_rapat' => $request->jabatan_pimpinan_rapat,
            'sekretaris' => $request->nama_sekretaris,
            'jabatan_sekretaris' => $request->jabatan_sekretaris,
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
        dd($del);
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

    public function update_status(){
        $id_rapat=$_POST['id_rapat'];
        $status_rapat=$_POST['status_rapat'];
        $update = Rapat::where('id_rapat',$id_rapat)
         ->update([
            'status_rapat' => $status_rapat,
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
