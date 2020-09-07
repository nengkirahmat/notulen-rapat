<?php
$data = session()->get('key');
if ($data[0]->level==1){
    $level="Admin";
    $nama=$data[0]->nama_lengkap;
}elseif ($data[0]->level==2){
    $level="Notulen";
    $nama=$data[0]->nama_lengkap;
}elseif ($data[0]->level==3){
    $level="Pimpinan";
    $nama=$data[0]->nama_lengkap;
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{config('app.name')}}</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">    
    <script src="/assets/js/jquery-2.1.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

    <!-- Data picker -->
   <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
   <!-- Clock picker -->
    <script src="/assets/js/plugins/clockpicker/clockpicker.js"></script>
   

<style>
    #loading {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 100px;
  height: 100px;
  animation: spin 2s linear infinite;
  margin: auto;
}

#preloading{
position: fixed;
left: 50%;
top: 40%;
transform: translate(-50%, -50%);    
width: 140px;
  height: 140px;
  text-align: center;
}

#canvasloading{
    width: 100%;
    background-color: rgba(255,255,255,0.7);
    height: 100%;
    z-index: 999999;
    position: absolute;
    display: none;
}

#txt{
    font-weight: 700;
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>

<body>
    <div id="canvasloading" class="lockscreen">

<div id="preloading">
    <div id="loading"></div>
    <p id="txt">Mohon Tunggu Sebentar...</p>
</div>
</div>
    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/assets/img/kotasolok2.gif" width="60px" />
                             </span>

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{$nama}}</strong>

                             </span> <span class="text-muted text-xs block">{{$level}}</span> </a>
                        
                    </div>
                    <div class="logo-element">
                        RAPAT
                    </div>
                </li>
                @if($level=="Admin")
                <li>
                    <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="/rapat"><i class="fa fa-edit"></i> <span class="nav-label">Data Rapat</span></a>
                </li>
                <li>
                    <a href="/proses"><i class="fa fa-spinner"></i> <span class="nav-label">Rapat Proses</span></a>
                </li>
                <li>
                    <a href="/selesai"><i class="fa fa-check"></i> <span class="nav-label">Rapat Selesai</span></a>
                </li>
                <li>
                    <a href="/batal"><i class="fa fa-times"></i> <span class="nav-label">Rapat Dibatalkan</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Master Rapat</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="/jenis"><i class="fa fa-circle-o"></i> Jenis Rapat</a></li>
                        <li><a href="/tempat"><i class="fa fa-circle-o"></i> Tempat Rapat</a></li>
                        <li><a href="anggotadprd"><i class="fa fa-circle-o"></i> Anggota DPRD</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Master Produk Hukum</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="kelhukum"><i class="fa fa-circle-o"></i> Kelompok Hukum</a></li>
                        <li><a href="kathukum"><i class="fa fa-circle-o"></i> Kategori Hukum</a></li>
                        <li><a href="produkhukum"><i class="fa fa-circle-o"></i> Produk Hukum</a></li>
                    </ul>
                </li>
                @elseif($level=="Notulen")
                <li>
                    <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
                </li>
                <li>
                    <a href="/rapat"><i class="fa fa-edit"></i> <span class="nav-label">Data Rapat</span></a>
                </li>
                <li>
                    <a href="/proses"><i class="fa fa-spinner"></i> <span class="nav-label">Rapat Proses</span></a>
                </li>
                <li>
                    <a href="/selesai"><i class="fa fa-check"></i> <span class="nav-label">Rapat Selesai</span></a>
                </li>
                <li>
                    <a href="/batal"><i class="fa fa-times"></i> <span class="nav-label">Rapat Dibatalkan</span></a>
                </li>
                @elseif($level=="Pimpinan")
                <li>
                    <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span></a>
                </li>
                @endif
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
            <!--    
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="mailbox.html">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="profile.html">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            -->
                <li>
                   <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </li>
            </ul>

        </nav>
        </div>
            
        @yield("content")
        
            <!-- <div class="footer">
                <div class="pull-right">
                    
                </div>
                <div>
                    <strong>Copyright</strong> Pemerintah Kota Solok &copy; 2020
                </div>
            </div>
 -->
        </div>
        </div>


    <!-- Mainly scripts -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/assets/js/inspinia.js"></script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

</body>

</html>
