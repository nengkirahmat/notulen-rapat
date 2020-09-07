<?php

namespace App\Http\Controllers;

use App\Hukum;
use App\Kelhukum;
use App\Kathukum;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
class HukumController extends Controller
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
        $hukum = DB::table('hukum')
                    ->select('hukum.*','kelhukum.nama_kel','kathukum.nama_kat')
                    ->join('kelhukum','kelhukum.id_kel','=','hukum.kelompok')
                    ->join('kathukum','kathukum.id_kat','=','hukum.kategori')
                    ->latest()
                    ->get();
        if ($request->ajax()) {
            return Datatables::of($hukum)
                ->addIndexColumn()
                ->addColumn('file_hukum',function ($row){
                    if ($row->status_hukum<>""){
                        return "<a href='/file/".$row->file_hukum."' target='_blank'>Download</a>";
                    }else{
                        return "Tidak Ada";
                    }
                })
                ->addColumn('status_hukum',function ($row){
                    if ($row->status_hukum==1){
                        return "Aktif";
                    }elseif($row->status_hukum==2){
                        return "Non Aktif";
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_hukum="' . $row->id_hukum . '" data-original-title="Edit" class="edit btn btn-primary btn-xs edithukum"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_hukum="' . $row->id_hukum . '" data-original-title="Delete" class="btn btn-danger btn-xs deletehukum"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['file_hukum','status_hukum','action'])
                ->make(true);
        }
        $kelompok=Kelhukum::All();
        return view('hukum.data_hukum', compact(array('hukum','kelompok')));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Upload File
       $request->validate([
            'file_hukum.*' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar|max:3024',
            'id_kat' => 'required',
            'id_kel' => 'required',
            'nama_hukum' => 'required',
            'tgl_hukum' => 'required',
            'tentang' => 'required',
            'status_hukum' => 'required',
        ]);
        // menyimpan data file yang diupload ke variabel $file

        $file = $request->file('file_hukum');
 
        $nama_file = time()."_".$file->getClientOriginalName();
 
                // isi dengan nama folder tempat kemana file diupload
        
        $file->move(public_path().'/file/',$nama_file);
 
        $save=Hukum::updateOrCreate([
            'id_hukum' => $request->id_hukum
        ],[
            'kelompok' => $request->id_kel,
            'kategori' => $request->id_kat,
            'nama_hukum' => $request->nama_hukum,
            'tentang' => $request->tentang,
            'tgl_hukum' => $request->tgl_hukum,
            'status_hukum' => $request->status_hukum,
            'file_hukum' => $nama_file,
        ]);
        if ($save) {
         return redirect()->back()->with("alert","Produk Hukum Berhasil Disimpan...!!!");
        }else{
            echo "Terjadi Kesalahan";
            die();
        }

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\hukum $hukum
     * @return \Illuminate\Http\Response
     */
    public function edit($id_hukum)
    {
        $hukum = Hukum::find($id_hukum);
        return response()->json($hukum);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_hukum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Hukum::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'hukum deleted successfully.',
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
