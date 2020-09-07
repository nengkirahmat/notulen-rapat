<?php

namespace App\Http\Controllers;
use App\Notulen;
use App\Rapat;
use App\Jenis;
use App\Tempat;
use App\Peserta;
use App\Pegawai;
use App\Gambar;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class NotulenController extends Controller
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
        $data=session()->get('key');
        $id_user=$data[0]->id_user;
        $proses=Notulen::updateOrCreate([
            'id_rapat' => $request->id_rapat
        ],[
            'id_rapat' => $request->id_rapat,
            'id_user' => $id_user,
            'isi_rapat' => $request->isi_rapat,
            'kesimpulan' => $request->kesimpulan,
            'status_notulen' => $request->status_notulen,
            ]);
        $status=Rapat::where('id_rapat',$request->id_rapat)
                        ->update(['status_rapat'=>$request->status_rapat,'jam_akhir'=>$request->jam_akhir]);
        //Upload
        $this->validate($request, [
                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);
        
        if($request->hasfile('filename'))
        {
            foreach($request->file('filename') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/img/', $name);  // your folder path
                $Upload_model = new Gambar;
                $Upload_model->id_rapat = $request->id_rapat;
                $Upload_model->nama_gambar = $name;
                $Upload_model->save(); 
            }
        }
        
     
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

        $peserta = Peserta::where("peserta.id_rapat",$id)
                            ->join("rapat","rapat.id_rapat","=","peserta.id_rapat")
                            ->get();
        if ($request->ajax()) {
            return Datatables::of($peserta)
                ->addIndexColumn()
                ->addColumn('status_hadir',function ($row){
                    if ($row->status_rapat==3 or $row->status_rapat==4){
                        if ($row->status_hadir==1){
                            return "Hadir";
                        }else{
                            return "Tidak Hadir";
                        }    
                    }else{
                    if ($row->status_hadir==1){
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='1' data-id='".$row->id_peserta."' checked='true'> Hadir";
                    }elseif($row->status_hadir==2){
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='2' data-id='".$row->id_peserta."'> Tidak Hadir";
                    }else{
                        return "<input type='checkbox' id='status_hadir' name='status_hadir' value='0' data-id='".$row->id_peserta."'> Belum Absen";
                    }
                }
                })
                ->addColumn('action', function ($row) {
                    if ($row->status_rapat==3 or $row->status_rapat==4){
                        $btn="";    
                    }else{
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editpeserta"><i class="fa fa-pencil"></i> Ubah</a>';

                    // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_peserta="' . $row->id_peserta . '" data-original-title="Delete" class="btn btn-danger btn-xs deletepeserta"><i class="fa fa-trash"></i> Hapus</a>';
                    }
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
        $gambar=DB::table('gambar')->where('id_rapat',$id)->get();
        return view('notulen.data_proses', compact(array('peserta','rapat','data_notulen','gambar')));
    }


    public function browse(Request $request){
        $data = Pegawai::whereRaw("(nama_lengkap LIKE '%".$request->get('q')."%' OR nip_user LIKE '%".$request->get('q')."%' OR id_user LIKE '%".$request->get('q')."%')")
                ->limit(30)
                ->get();
        return response()->json($data);
    }

    public function print($id){
        $id=Crypt::decrypt($id);
        $rapat=DB::table('rapat')
                    ->join('notulen','notulen.id_rapat','=','rapat.id_rapat')
                    ->join('tbl_user','tbl_user.id_user','=','notulen.id_user')
                    ->join('jenis','jenis.id_jenis','=','rapat.id_jenis')
                    ->join('tempat','tempat.id_tempat','=','rapat.id_tempat')
                    ->where('rapat.id_rapat','=',$id)
                    ->get();
        $peserta=Peserta::where('id_rapat','=',$id)
                        ->where('status_hadir','=',1)
                        ->get();
        return view('notulen.print',compact(array('rapat','peserta')));
    }
    

    public function speech(){
        return view("notulen.web-speech");
    }

}
