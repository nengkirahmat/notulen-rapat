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
        return view('notulen.data_notulen');
    }
    
    public function index1(Request $request)
    {
       return view('notulen.data_selesai');
    }
    
    public function index2(Request $request)
    {
       return view('notulen.data_batal');
    }
    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proses=Notulen::updateOrCreate([
            'id_rapat' => $request->id_rapat
        ],[
            'id_rapat' => $request->id_rapat,
            'id_user' => 1,
            'isi_rapat' => $request->isi_rapat,
            'status_notulen' => $request->status_notulen,
            ]);
        $status=Rapat::where('id_rapat',$request->id_rapat)
                        ->update(['status_rapat'=>$request->status_rapat]);
        // return response
        if ($proses and $status){
        $response = [
            'success' => true,
            'message' => 'Berhasil Disimpan.',
        ];
        return redirect()->back()->with($response);
        }
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
        if (!empty($request->id)){
        $id=$request->id;
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
        $data_notulen=Notulen::where('id_rapat',$id)->get();
        return view('notulen.data_proses', compact(array('peserta','rapat','data_notulen')));
    }

    

}
