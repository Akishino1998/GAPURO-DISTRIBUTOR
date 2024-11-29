<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="description" content="APDERIS adalah aplikasi management data servis, sparepart dan pembukuaan keuangan">
    <meta name="keywords" content="APDERIS, servis, pencatatan data servis, data servis, management servis, sparepart, pembukuan, akuntansi, buku kas">
    <meta name="author" content="Owafs Technology">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34=">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>APDERIS | Aplikasi Manajemen Data Servis, Sparepart Dan Pembukuan</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .badge-primary{
            background: #EE9D01 !important;
        }
    </style>
    @yield('css')
</head>
@livewireStyles
<body class="hold-transition layout-top-nav" >
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('img/logo-black.png') }}" alt="APDERIS" class="brand-image">
                </a>
                <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse" style="margin-top:10px">
                    <ul class=" navbar-nav navbar-no-expand ml-auto" >
                        <li class="nav-item">
                            <a href="{{ route('tutorial') }}" class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121;width: 120px">
                                <strong><i class="fas fa-book-open"></i> Tutorial</strong>
                            </a>
                        </li>
                        <li class="nav-item" style="width: 100%">
                            <form action="{{ route('cekServisan') }}" method="get" class="quick-search-form mr-2">
                                <div class="d-flex align-items-center input-group w-250px mr-1">
                                    <input type="text" class="form-control" placeholder="Cari No. Servis" name="servisan" required="" style="border: 1px solid black;">
                                    <div class="input-group-append ">
                                        <button type="submit" class="btn btn-primary font-weight-bolder" style="border-color:#242121;background-color:#242121;color:white">Go!</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                        @if (Route::has('login'))
                            @auth
                                @php
                                    $akses = [3,4,5]
                                @endphp
                                @if(Auth::user()->id_role == 2)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" data-toggle="dropdown" href="#"  style="padding: 0px">
                                            <button  class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121">
                                                <i class="fas fa-store" style="color: white"></i>
                                            </button>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                            <span class="dropdown-header" style="background: #EE9D01">
                                                <a href="{{ route('bukaToko') }}" class="btn btn-primary btn-sm" style="border-color:#242121;background-color:#242121;color:white"><i class="fas fa-plus    "></i> Buka Toko Baru</a>
                                                <a href="{{ route('perpanjang') }}" class="btn btn-primary btn-sm" style="border-color:#242121;background-color:#242121;color:white"><i class="fas fa-rocket    "></i> Perpanjang</a>
                                            </span>
                                            @foreach ($provider_Toko as $item)
                                                <div class="dropdown-divider"></div>
                                                <a href="{{ route('dashboardToko') }}?toko={{ $item->id }}" class="dropdown-item">
                                                    {{ $item->nama_toko }}
                                                </a>
                                            @endforeach
                                            @if (COUNT($provider_Toko)==0)
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item">
                                                    Kamu Belum Punya Toko
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                @elseif ( in_array(Auth::user()->id_role, $akses) )
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard') }}" class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121;color:white"><b><i class="fas fa-store"></i></b></a>
                                    </li>
                                @elseif(Auth::user()->id_role == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard-admin') }}" class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121;color:white"><b><i class="fas fa-home"></i></b></a>
                                    </li>
                                @elseif(Auth::user()->id_role == 6)
                                    <li class="nav-item">
                                        <a href="{{ route('bukaToko') }}" class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121;color:white"><b><i class="fas fa-store-alt"></i> </b></a>
                                    </li>
                                @endif
                                
                                <li class="nav-item dropdown user-menu">
                                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="padding: 0px">
                                        <button  class="btn btn-primary mr-2" style="border-color:#242121;background-color:#242121">
                                            <span class="d-none d-lg-inline"><span style="color:white">Hai, </span><b style="color: #F8C25C">{{ Auth::user()->name }}</b></span>
                                            <span class="d-lg-none"><i class="fa fa-user" aria-hidden="true"></i> </span>
                                        </button>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                        <!-- User image -->
                                        <li class="user-header bg-primary" style="background-color:#EE9D01 !important">
                                            <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                                            <p>
                                                Hai, <b>{{ Auth::user()->name }}</b>
                                                <small>Terdaftar sejak {{ Auth::user()->created_at->format('M. Y') }}</small>
                                            </p>
                                        </li>
                                        <!-- Menu Footer-->
                                        <li class="user-footer">
                                            <a href="{{ route('changePass') }}" class="btn btn-default btn-flat">Ganti Password</a>
                                            <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Sign out
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="btn btn-primary mr-2" style="border-color:#EE9D01;background-color:#EE9D01;color:white"><b>Login</b></a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary" style="border-color:#242121;background-color:#242121;color:#F8C25C"><b>Daftar</b></a>
                                </li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="content-header"style="background-image: url({{ asset('bg-apderis.jpg') }});background-size: contain;min-height:100vh">
                <div class="container">
                    @yield('konten')
                </div>
            </div>
        </div>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
        @include('layouts.footer')
       
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> --}}
</body>
</html>
@if (session()->has('msg'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Tidak Dapat Akses',
            text: '{{ session("msg") }}'
        })
    </script>
@endif
@if (session()->has('msg-success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("msg-success") }}'
        })
    </script>
@endif
@yield('js')
@livewireScripts
