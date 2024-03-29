<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Hukum;
use App\Kelhukum;
use App\Kathukum;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (!empty($request->id)){
            if ($request->id=="all"){
                $kelompok = Kelhukum::All();
                $hukum = Hukum::where('status_hukum','=','1')->paginate(10);
            }else{
                $id=decrypt($request->id);
                $kelompok = Kelhukum::All();
                $hukum = Hukum::where('kategori','=',$id)->where('status_hukum','=','1')
                ->paginate(10);
            }
        }else{
            $kelompok = Kelhukum::All();
                $hukum = Hukum::where('status_hukum','=','1')->paginate(10);
        }
        $rapat = DB::table('rapat')
        ->select("rapat.*","jenis.nama_jenis","tempat.nama_tempat")
        ->join('jenis', 'jenis.id_jenis', '=', 'rapat.id_jenis')
        ->join('tempat', 'tempat.id_tempat', '=', 'rapat.id_tempat')
        //->leftJoin('notulen','notulen.id_rapat','=','rapat.id_rapat')
        ->orWhereNull("rapat.deleted_at")
        ->where("rapat.status_rapat",'=','3')
        ->where("rapat.sifat_rapat",'=','Terbuka')
        ->latest()
        ->get();
        return view("home",compact(array('kelompok','hukum','rapat')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
