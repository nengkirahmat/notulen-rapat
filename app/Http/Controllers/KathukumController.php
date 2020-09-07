<?php

namespace App\Http\Controllers;

use App\Kathukum;
use App\Kelhukum;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
class KathukumController extends Controller
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
        $kat = DB::table('kathukum')
        ->select('kathukum.id_kat','kathukum.nama_kat','kelhukum.id_kel','kelhukum.nama_kel')
        ->join('kelhukum', 'kelhukum.id_kel', '=', 'kathukum.kelompok')
        ->latest('kathukum.id_kat')
        ->get();

        if ($request->ajax()) {
            return Datatables::of($kat)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_kat="' . $row->id_kat . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editkategori"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_kat="' . $row->id_kat . '" data-original-title="Delete" class="btn btn-danger btn-xs deletekategori"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $kelompok=Kelhukum::All();
        return view('kathukum.data_kathukum', compact(array('kat','kelompok')));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kathukum::updateOrCreate([
            'id_kat' => $request->id_kat
        ],[
            'kelompok' => $request->kelompok,
            'nama_kat' => $request->nama_kat,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Kategori Hukum saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\kategori $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit($id_kat)
    {
        $kat = Kathukum::find($id_kat);
        return response()->json($kat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_katompok
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Kathukum::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'Kategori Hukum Berhasil Dihapus.',
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

    public function getkategori(Request $request){
        $kategori=Kathukum::where('kelompok','=',$request->id)->get();
        ?>
        <option value="">Pilih Kategori Hukum</option>
        <?php
        foreach ($kategori as $k) {
        ?>
        <option value="<?php echo $k->id_kat ?>"><?php echo $k->nama_kat ?></option>
        <?php
        }
    }
}
