<!doctype html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/assets/img/kotasolok2.gif">

     <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/jumbotron.css" rel="stylesheet">
  </head>

  <body style="padding: 0">
<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="{{ url('/') }}"><img src="/assets/img/kotasolok2.gif" width="30" height="30" alt="Malas Ngoding"> {{ config('app.name', 'Laravel') }}</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Beranda <span class="sr-only">(current)</span></a>
        </li>
<!--         <li class="nav-item">
          <a class="nav-link" href="/kategori/all">Produk Hukum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/hasil-rapat">Hasil Rapat</a>
        </li> -->
<!--         <li class="nav-item">
          <a class="nav-link" href="#">Tentang</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tutorial
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Tutorial HTML</a>
            <a class="dropdown-item" href="#">Tutorial CSS</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Tutorial Bootstrap</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Link Mati</a>
        </li> -->
      </ul>
@guest
      <span class="navbar-text mr-3">
        Silahkan login
      </span>
      <a href="/dashboard" class="btn btn-outline-success mr-2">Login</a>
@else
<a  class="btn btn-outline-success mr-2" href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                    <a  class="btn btn-outline-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @endguest
    </div>

</nav>
   

    <main role="main">
  


  <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron" style="background-image: url('/bg1.jpg'); background-repeat: no-repeat;background-position: center; background-size: 100%;">
        <div class="container" style="min-height: 200px;">
          <!-- <h1 class="display-3">Hello, world!</h1>
          <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
          <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
        </div>
      </div>
@yield('content')
    </main>
<!-- Footer -->
<footer class="bg-primary">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3" style="color: white;">© Pemerintah Kota Solok - 2020</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
  </body>
</html>
