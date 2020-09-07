<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{config('app.name')}}</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h1 style="text-align: center; font-weight: 700;">{{config('app.name')}}<br><small>PEMERINTAH KOTA SOLOK</small></h1>
               <img width="100%" src="{{url('assets/img/rapat-img2.png')}}"/>
            </div>
            <div class="col-md-6"><br>
                <div class="ibox-title">
                    <h5>Login Pengguna</h5>
                </div>
                <div class="ibox-content">
                    @if(!empty(session("alert")))
                    <div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            {{session("alert")}}
                            </div>
                    @endif
                    <form class="m-t" method="POST" action="{{ url('loginPegawai') }}">
                        @csrf

                        <div class="form-group">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>

                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>NIP/Username tidak boleh kosong...!!!</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>Password tidak boleh kosong...!!!</strong>
                            </span>
                            @enderror
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">

                            <label class="form-check-label" for="remember">
                                {{ __('Ingat Saya!') }}
                            </label>
                        </div> -->
                        <button type="submit" class="btn btn-primary block full-width m-b">
                            {{ __('Login') }}
                        </button>

                        <!-- @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                        @endif
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('Daftar') }}
                        </a> -->

                    </form>
                    <p class="m-t">
                        <small>&copy; Pemerintah Kota Solok - 2020</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <!-- <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2014-2015</small>
           </div>
       </div> -->
   </div>
<script src="/assets/js/jquery-3.1.1.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
</body>

</html>
