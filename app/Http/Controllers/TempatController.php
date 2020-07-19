<?php

namespace App\Http\Controllers;

use App\Tempat;
use Illuminate\Http\Request;
use DataTables;

class TempatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tempat = Tempat::latest()->get();

        if ($request->ajax()) {
            return Datatables::of($tempat)
            ->addIndexColumn()
            ->addColumn('status_tempat',function ($row){
                if ($row->status_tempat==1){
                    return "Aktif";
                }elseif($row->status_tempat==2){
                    return "Non Aktif";
                }
            })
            ->addColumn('action', function ($row) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id_tempat="' . $row->id_tempat . '" data-original-title="Edit" class="edit btn btn-primary btn-xs edittempat"><i class="fa fa-pencil"></i> Ubah</a>';

                $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id_tempat="' . $row->id_tempat . '" data-original-title="Delete" class="btn btn-danger btn-xs deletetempat"><i class="fa fa-trash"></i> Hapus</a>';

                return $btn;
            })
            ->rawColumns(['status_tempat','action'])
            ->make(true);
        }

        return view('tempat.data_tempat', compact('tempat'));
    }

    /**
     * Store/update resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id=tempat::updateOrCreate([
            'id_tempat' => $request->id_tempat
        ],[
            'nama_tempat' => $request->nama_tempat,
            'status_tempat' => $request->status_tempat,
        ])->id_tempat;

        // return response
        $response = [
            'id_tempat' => $id,
            'success' => true,
            'message' => 'Tempat saved successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\tempat $tempat
     * @return \Illuminate\Http\Response
     */
    public function edit($id_tempat)
    {
        $tempat = Tempat::find($id_tempat);
        return response()->json($tempat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id_tempat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del=Tempat::destroy($id);

        // return response
        if ($del){
            $response = [
                'success' => true,
                'message' => 'tempat deleted successfully.',
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

    public function data_tempat(){
        $tempat=Tempat::All();
        ?>
        <option value="">Pilih Tempat</option>
        <option value="" id="lain" style="font-size: 18px;">Buat Tempat Baru</option>
        <?php
        foreach($tempat as $t){
            echo "<option class='ada' value='".$t->id_tempat."'>".$t->nama_tempat."</option>";
        }
    }
}
