<?php

namespace App\Http\Controllers;

use App\Anggotadprd;
use Illuminate\Http\Request;
use DataTables;

class AnggotadprdController extends Controller
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
        $anggotadprd = Anggotadprd::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($anggotadprd)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_anggotadprd="' . $row->id_anggotadprd . '" data-original-title="Edit" class="edit btn btn-primary btn-xs editanggotadprd"><i class="fa fa-pencil"></i> Ubah</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_anggotadprd="' . $row->id_anggotadprd . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteanggotadprd"><i class="fa fa-trash"></i> Hapus</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('anggotadprd.data_anggotadprd', compact('anggotadprd'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        anggotadprd::updateOrCreate([
            'id_anggotadprd' => $request->id_anggotadprd
        ],[
            'nama_anggotadprd' => $request->nama_anggotadprd,
            'jabatan_anggotadprd' => $request->jabatan_anggotadprd,
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'Anggota dprd saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\anggotadprd $anggotadprd
     * @return \Illuminate\Http\Response
     */
    public function edit($id_anggotadprd)
    {
        $anggotadprd = Anggotadprd::find($id_anggotadprd);
        return response()->json($anggotadprd);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_anggotadprd
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Anggotadprd::destroy($id);

        // return response
        if ($del){
        $response = [
            'success' => true,
            'message' => 'anggota dprd deleted successfully.',
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


    public function browse(Request $request){
        $data = Anggotadprd::whereRaw("(nama_anggotadprd LIKE '%".$request->get('q')."%')")
                ->get();
        return response()->json($data);
    }

     public function get_user($id)
    {
        $data = Anggotadprd::select("id_anggotadprd","nama_anggotadprd","jabatan_anggotadprd")
                ->whereRaw("id_anggotadprd='$id'")
                ->first();
        return response()->json($data);
    }

     public function get_pimpinan($id)
    {
        $data = Anggotadprd::select("id_anggotadprd","nama_anggotadprd","jabatan_anggotadprd")
                ->whereRaw("id_anggotadprd='$id'")
                ->first();
        return response()->json($data);
    }

     public function get_sekretaris($id)
    {
        $data = Anggotadprd::select("id_anggotadprd","nama_anggotadprd","jabatan_anggotadprd")
                ->whereRaw("id_anggotadprd='$id'")
                ->first();
        return response()->json($data);
    }
}
