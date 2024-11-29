<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8"/>
        <title>Masuk | APDERIS</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="APDERIS adalah aplikasi management data servis, sparepart dan pembukuaan keuangan">
        <meta name="keywords" content="APDERIS, servis, pencatatan data servis, data servis, management servis, sparepart, pembukuan, akuntansi, buku kas">
        <meta name="author" content="Owafs Technology">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <link href="{{ asset('dist/assets/css/pages/login/login-3.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('dist/assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('dist/assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('dist/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <style>
        .login.login-3 .login-aside .aside-img {
            background-size: auto; 
            background-color: #fdb746 ;
        }    
        .flex-column-auto
        {
           background-color: #fdb746;
        }
        *{
            font-family: 'Rubik'; 
        }
    </style>
    <body dy id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled sidebar-enabled page-loading"  >
        <div class="d-flex flex-column flex-root">
            <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid">
                <div class="login-content flex-row-fluid d-flex flex-column p-10">
                    <div class="d-flex flex-row-fluid flex-center">
                        <div class="login-form">
                            <form class="form" id="" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="pb-2 pb-md-10">
                                    <h3 class="font-weight-bolder text-dark display-4">Masuk</h3>
                                </div>
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Emailmu</label>
                                    <input class="form-control h-auto py-7 px-6 rounded-lg border-0 @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus tabindex="1">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                    </div>
                                    <input class="form-control h-auto py-7 px-6 rounded-lg border-0 @error('password') is-invalid @enderror" id="password"  type="password" name="password" required autocomplete="current-password" tabindex="2"/>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="pb-lg-5 pb-10">
                                    <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-warning btn-lg btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>