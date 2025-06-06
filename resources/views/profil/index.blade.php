<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#FFD31A">
    <link rel="stylesheet" href="{{ asset('profil/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/progressbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('profil/css/slick.css') }}"/>
    <link rel="icon" type="image/png" href="{{ asset('owafs-indonesia.ico') }}">
    <style>
        .startup-home-area .d-table{
            padding-top: 20vmin;
        }
        .startup-home-area{
            background-color:white;
        }
        .startup-home-area .hero-content h1{
            color: #116530;
        }
        .startup-home-area .hero-content span {
            background: #116530;
            color: white;
            font-size: 20px;
        }
        .navbar-area-two.is-sticky {
            background: #116530  !important;
        }
        .navbar-area-two .exto-nav .navbar .navbar-nav .nav-item a{
            color: #116530;
            font-size: 20px;
        }
        .exto-nav .navbar .others-options.saas-option .saas-nav-btn{
            background-color:#116530 ;
            color: white;
            border:1px solid #116530;
        }
        .productive-section{
            background: #116530;
        }
        .what-we-do-section{
            background: white !important;
        }
        .we-do-content-area h3{
            color: black;
        }
        .we-do-content-area p{
            color: black;
        }
        .navbar-area-two .exto-responsive-nav .mean-container a.meanmenu-reveal span{
            background: black;
        }
        .card-top{
            padding:100px 0px!important;
            max-height:500px!important;
            background-image:none !important;
        }
         .card-bottom{
            margin-top : -50px !important;
            min-height : 0px !important;
            padding-top: 0px !important;
        }
 
    </style>
    <title>GAPURO   </title>
</head>
<body>
    <!-- Start Navbar Area Two -->
    <div class="navbar-area-two">
        <div class="exto-responsive-nav">
            <div class="container">
                <div class="exto-responsive-menu">
                    <div class="logo">
                        <a href="/" id="tempatLogoHP">
                            <img src="{{ asset('profil/img/gapuro/GPA-WebAsset-01.svg') }}" alt="logo" style="height: 6vmin">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="exto-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light">
                    <a class="navbar-brand" id="tempatLogo" href="/">
                        <img id="logo" src="{{ asset('profil/img/gapuro/GPA-WebAsset-01.svg') }}" alt="logo" style="height: 6vmin">
                    </a> 
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav" style="margin-right: 0">
                            <li class="nav-item"><a href="#home" class="nav-link">Home</a></li>
                            <li class="nav-item"><a href="#produk" class="nav-link">Our Products</a></li>
                            <li class="nav-item"><a href="#about" class="nav-link">About Us</a></li>
                            <li class="nav-item"><a href="#news" class="nav-link">News</a></li>
                            <li class="nav-item btn-login" id="fadeshow1">                            
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        </ul>
                        <div class="others-options saas-option" >
                            <a class="saas-nav-btn" href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </nav>
                <div class="div-transparent" style="position: sticky"></div>
            </div>
        </div>
    </div>
    <div class="startup-home-area">
        <div class="d-table" id="home" >
            <div class="d-table-cell">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-12" style="z-index: 1">
                            <div class="hero-content">
                                <span>Dari Ladang Ke Meja</span>
                                <h1>Pangan Berkualitas Untuk Kebutuhan Anda</h1>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            {{-- <div class="startup-image"> --}}
                                <img src="{{ asset('profil/img/gapuro/GPA-WebAsset-03.svg') }}" class="wow fadeInUp" data-wow-delay="0.6s" alt="image">
                            {{-- </div> --}}
                        </div>
                        <div class="startup-shape">
                            <img src="{{ asset('profil/img/startup-home/startup-shape-2.png') }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shape-img1"><img src="{{ asset('profil/img/shape/1.svg') }}" alt="image"></div>
        <div class="shape-img2"><img src="{{ asset('profil/img/shape/2.svg') }}" alt="image"></div>
        <div class="shape-img3"><img src="{{ asset('profil/img/shape/3.png') }}" alt="image"></div>
        <div class="shape-img4"><img src="{{ asset('profil/img/shape/4.png') }}" alt="image"></div>
        <div class="shape-img5"><img src="{{ asset('profil/img/shape/6.png') }}" alt="image"></div>
    </div>
    <section id="productive-section" class="productive-section pt-100 pb-70" >
        <div class="container-fluid" id="produk">
            <div class="productive-title">
                <h3 style="color: white">Produk Pangan Berkualitas
                    <br>Untuk Setiap Kebutuhan</h3>
            </div>
            <div class="productive-area-content justify-content-center slick-track">
                <div class="productive-area-item col-md-10 mx-4 corner" data-title="Sayur-Sayuran">
                    <div class="card-top">
                        <div class="content">
                            <p><i class="fas fa-dot-circle"></i> Bayam</p>
                        </div>
                        <div class="content">
                            <p><i class="fas fa-dot-circle"></i> Wortel</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Jagung</p>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <div>
                            <h3>Sayur-Sayuran</h3>
                            <p>Sayuran segar berkualitas tinggi</p>
                        </div>
                    </div>
                </div>
                <div class="productive-area-item col-md-10 mx-4 tech" data-title="Buah-Buahan">
                    <div class="card-top">
                        <div class="content">
                            <p><i class="fas fa-dot-circle"></i> Apel</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Jeruk</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Semangka</p>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <h3>Buah-Buahan</h3>
                        <p>Aneka buah segar yang kaya akan rasa dan manfaat</p>
                    </div>
                </div>
                <div class="productive-area-item col-md-10 mx-4 creative" data-title="Lauk Pauk">
                    <div class="card-top">
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Ayam</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Ikan</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Daging Sapi
                            </p>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <h3>Lauk Pauk</h3>
                        <p>Menyediakan menu berkualitas yang kaya akan protein</p>
                    </div>
                </div>
                <div class="productive-area-item col-md-10 mx-4 space" data-title="Susu">
                    <div class="card-top">
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Susu Sapi</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Susu Kambing</p>
                        </div>
                        <div class="content">
                            <p><i class="fa fa-dot-circle"></i> Susu Oat</p>
                        </div>
                    </div>
                    <div class="card-bottom">
                        <h3>Susu</h3>
                        <p>Susu segar kaya akan gizi dari peternakan terbaik</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="productive-section" class="productive-section pt-100 pb-70" >
        <div class="container-fluid" id="produk">
            <img src="{{ asset('img/info.png') }}" alt="" srcset="">
        </div>
    </section>
    <section class="what-we-do-section-2" id="about">
        <div class="what-we-do-section px-4 ptb-100" style="-webkit-border-radius:0">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12">
                        <div class="we-do-content-area">
                            <h3>About Us</h3>
                            <p>---</p>
                            <div class="we-btn">
                                <a href="#" class="we-btn-one">Discover More</a>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-lg-6 col-md-12" style="text-align: -webkit-center">
                        <div class="we-do-image">
                            <img class="" src="{{ asset('profil/img/gapuro/GPA-WebAsset-09.svg') }}" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-section startup-blog pt-100 pb-70" id="news">
        <div class="container">
            <div class="blog-title">
                <h3>Halaman Berita</h3>
                <div class="blog-btn">
                    <a href="#" class="blog-btn-one">Tampilkan Semua</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-image">
                            <a href="single-blog.html">
                                <img src="{{ asset('profil/img/gapuro/news3.jpg') }}" alt="image">
                            </a>
                        </div>
                        <div class="single-blog-item">
                            <div class="blog-content">
                                <a href="single-blog.html">
                                    <h3>Persawahan Indonesia</h3>
                                </a>
                            </div>
                            <ul class="blog-list">
                                <li>
                                    <a href="single-blog.html">
                                        <i class="flaticon-pen"></i> 
                                        Admin
                                    </a>
                                </li>
                                <li>
                                    <i class="flaticon-appointment"></i> 
                                    01 Januari 2025
                                </li>
                            </ul>
                        </div>  
                    </div>  
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="blog-item">
                        <div class="blog-image">
                            <a href="single-blog.html">
                                <img src="{{ asset('profil/img/gapuro/news2.jpg') }}" alt="image">
                            </a>
                        </div>
                        <div class="single-blog-item">
                            <div class="blog-content">
                                <a href="single-blog.html">
                                    <h3>Perkebunan Indonesia</h3>
                                </a>
                            </div>
                            <ul class="blog-list">
                                <li>
                                    <a href="#">
                                        <i class="flaticon-user"></i> 
                                        Admin
                                    </a>
                                </li>
                                <li>
                                    <i class="flaticon-appointment"></i> 
                                    01 Januari 2025
                                </li>
                            </ul>
                        </div>  
                    </div>  
                </div>

                <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                    <div class="blog-item">
                        <div class="blog-image">
                            <a href="single-blog.html">
                                <img src="{{ asset('profil/img/gapuro/news1.jpg') }}" alt="image">
                            </a>
                        </div>
                        <div class="single-blog-item">
                            <div class="blog-content">
                                <a href="single-blog.html">
                                    <h3>Peternakan Indonesia</h3>
                                </a>
                            </div>
                            <ul class="blog-list">
                                <li>
                                    <a href="#">
                                        <i class="flaticon-user"></i> 
                                        Admin
                                    </a>
                                </li>
                                <li>
                                    <i class="flaticon-appointment"></i> 
                                    01 Januari 2025
                                </li>
                            </ul>
                        </div>  
                    </div>  
                </div>
            </div>
        </div>
    </section>
    <section class="provide-section ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="provide-image">
                        <img src="{{ asset('profil/img/gapuro/GPA-WebAsset-10.svg') }}" alt="image">
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="provide-area-content">
                        <h3>Ada pertanyaan? Silahkan hubungi nomor dibawah ya!</h3>
                        <p></p>
                        <a href="https://api.whatsapp.com/send?phone=+6281247529500&text=Hai, Owafs Indonesia! Mau Nanya Dong!" class="provide-contact"><i class="fab fa-whatsapp"></i> &nbsp; Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Provide Section -->

    <!-- Start Footer Section -->
    <footer class="footer-section marketing-footer">
        <div class="container">
            <div class="row justify-content-center pb-5">
                <div class="col-md-12 pb-4 text-center">
                    <h3>See Our Bussiness</h3>
                </div>
                <div class="col-md-9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.682144620749!2d117.13824005000001!3d-0.49314699999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc7dbec65c3e9969b!2sOwaf&#39;s%20Corner%20%7C%20Profesional%20Servis%20iPhone%20%26%20Servis%20Android!5e0!3m2!1sid!2sid!4v1642670393029!5m2!1sid!2sid" width="100%" height="300" style="border-radius:20px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="col-md-3 align-self-center">
                    <div class="single-footer-widget">
                        <ul class="footer-quick-links address-link">
                            <li>
                                <a href="#" class="p-0"><img src="{{ asset('profil/img/gapuro/GPA-WebAsset-01.svg') }}" alt=""></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-map-marker"></i>Jl. Siradj Salman</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-envelope"></i>test@gmail.com</a>
                            </li>
                            <li>
                                <a href="#" class><i class="fa fa-phone"></i>+62 812-4752-9500</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="justify-content-center text-center d-flex">
                <div class="px-5"><a href="">Tentang Kami</a></div>
                <div class="px-5"><a href="">Blog</a></div>
                <div class="px-5"><a href="">Bantuan</a></div>
                <div class="px-5"><a href="">Alamat</a></div>
                <div class="px-5"><a href="">Terms</a></div>
            </div>

            <div class="copyright-area">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <p>Copyright © {{ \Carbon\Carbon::now()->year }} Owafs Indonesia. All Rights Reserved
                        </p>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        {{-- <ul>
                            <li>
                                <a href="#">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="#">Terms & Conditions</a>
                            </li>
                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer Section -->

    <!-- Start Go Top Section -->
    <div class="go-top">
        <i class="fas fa-chevron-up"></i>
        <i class="fas fa-chevron-up"></i>
    </div>
    <!-- End Go Top Section -->

    <script src="{{ asset('profil/js/jquery.min.js') }}"></script>
    <script src="{{ asset('profil/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('profil/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('profil/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('profil/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('profil/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('profil/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('profil/js/wow.min.js') }}"></script>
    <script src="{{ asset('profil/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('profil/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('profil/js/progressbar.min.js') }}"></script>
    <script src="{{ asset('profil/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('profil/js/slick.min.js')}}"></script>
</body>
</html>
<script>
$(window).resize(function() {
if ($(this).width() < 480) {
  $('#fadeshow1').show();
} else {
  $('#fadeshow1').hide();
}
});
</script>