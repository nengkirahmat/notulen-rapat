<?php

namespace App\Http\Controllers;
use App\Pegawai;
use Illuminate\Http\Request;
class PegawaiController extends Controller
{
    public function login(Request $request)
    {
    	$request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);
    	$id_user=$request->username;
    	$password=strrev(sha1($request->password));
        $pegawai = Pegawai::where('id_user','=',$id_user)
        					->where('password','=',$password)
        					->first();
        if (!$pegawai){
        	session()->flash("alert","Login Gagal...!!!");
            return redirect('/login');
        }else{
        	if ($pegawai->level==1){
        		$request->session()->put(array("status"=>"admin"));
        		session()->push('key',$pegawai);
        		return redirect("nextlogin");

        	}elseif ($pegawai->level==2){
        		$request->session()->put(array("status"=>"notulen"));
        		session()->push('key',$pegawai);
        		return redirect("nextlogin");
        	}elseif ($pegawai->level==3){
        		$request->session()->put(array("status"=>"pimpinan"));
        		session()->push('key',$pegawai);
        		return redirect("nextlogin");
        	}else{
        		session()->flush();
        		session()->flash("alert","Akses tidak ditemukan...!!!");
        		return redirect("/login");
        	}
        }
    }


    public function userjson(){
    	$pegawai=Pegawai::select('nama_lengkap')
    	->take(5)
    	->get();
    	return response()->json($pegawai);
    }

   
}
