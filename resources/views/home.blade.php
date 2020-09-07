@extends('layouts.app')

@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>

-->


<div class="container">
    <div class="row">
    <div class="col-md-3">
        <h4>Produk Hukum</h4>
        <div style="width: 100%; height: 2px; background-color: red"></div>
          <ul class="web-vmenu">


            <li><a href="/kategori/all">Semua Dokumen</a></li>
            <?php
            Use App\Kathukum;

            foreach($kelompok as $kel){
              echo "<li><span>$kel->nama_kel</span>";
              echo "<ul class='active' style='padding-left:15px;'>";

              $id_kel=$kel->id_kel;
              $kategori=Kathukum::where('kelompok','=',$id_kel)->get();
              foreach ($kategori as $kat) {

                echo '<li><a href="/kategori/'.encrypt($kat->id_kat).'" style="text-transform:none;" class="lilia">'.$kat->nama_kat.'</a></li>';

              }

              echo '</ul>';
            }
            ?>  
          </ul>
</div>
  
<div class="col-md-6">
    <h4>Daftar Produk Hukum</h4>
    <div style="width: 100%; height: 2px; background-color: red"></div>
            @foreach($hukum as $h)

            <div style="border:1px solid #CCC; border-radius:4px; text-align:left; padding:1%; margin:5px 0; font-family:Arial; font-size:14px;">
              <table cellpadding="3" border="0">
                <tbody><tr>
                  <td colspan="3" valign="top"><b style="color:#000;">{{$h->nama_hukum}}</b>
                  </td></tr>
                  <tr>
                    <td colspan="3" valign="top"><p style="color:#004F75; margin: 0;">{{$h->tentang}}</p></td>
                  </tr>
                  <tr>
                    <td width="1" valign="top">Tahun</td><td width="1" valign="top">:</td><td valign="top">{{$h->tgl_hukum}}</td>
                  </tr>
                  <!-- <tr>
                    <td valign="top">Status</td><td valign="top">:</td><td valign="top">
                      @if($h->status_hukum==1)
                      {{"Aktif"}}
                      @elseif($sh->status_hukum==2)
                      {{"Non Aktif"}}
                      @endif
                    </td>
                  </tr>
                  <tr> -->
                    <td colspan="3" valign="top"><a href="{{url('download/'.encrypt($h->file_hukum))}}" style="font-weight:bold; color:#006DA0; text-decoration:none;">DOWNLOAD</a></td>
                  </tr>
                </tbody></table>
              </div>
              @endforeach



              <div style="text-align:left; line-height:35px; padding-top:0; padding-bottom:10px;">
                <span style="font-size:14px;">{{ $hukum->links() }}</span>
              </div>


            </div>
            <div class="col-md-3">
                <h4>Daftar Hasil Rapat</h4>
                <div style="width: 100%; height: 2px; background-color: red"></div>
                @foreach($rapat as $rapat)
                <div style="border:1px solid #CCC; border-radius:4px; text-align:left; padding:2%; margin:5px 0; font-family:Arial; font-size:14px;">
                    <b style="color: #000">{{$rapat->judul_rapat}}</b><br>
                    <small style="color: #004F75;">{{$rapat->hari." / ".date('d F Y',strtotime($rapat->tgl_rapat))}}</small><br>
                    {{$rapat->nama_tempat}}<br>
                    <a href="{{url('printnotulen/'.encrypt($rapat->id_rapat))}}" style="font-weight:bold; color:#006DA0; text-decoration:none;">DOWNLOAD HASIL RAPAT</a>
                </div>
                @endforeach
            </div>
</div>
</div>


@endsection
