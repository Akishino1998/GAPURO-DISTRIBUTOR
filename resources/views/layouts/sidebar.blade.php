<aside class="main-sidebar sidebar-dark-primary ">
    <div class="container">
        <div class="d-flex justify-content-center">
            <a href="/" class="brand-link">
                <img src="{{ asset('profil/img/gapuro/GPA-WebAsset-02.svg') }}" alt="APDERIS" class="brand-image " style="width: 100px">
            </a>
        </div>
    </div>
    <div class="sidebar">
        <div class="user-panel mt-3 mb-3 d-flex" style="border-bottom:0px">
            <div class="image">
              <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a  class="d-block">{{ Auth::user()->name }} (<span class="text-muted app-sidebar__user-name text-sm">{{ auth()->user()->Role->role }}</span>) </a>
            </div>
        </div>
        <div class=""  style="border-bottom:1px solid #4f5962;padding-bottom:10px">
            <div class="">
               
                <button type="button" class="btn btn-warning font-weight-bolder btn-md btn-pill mt-2" id="clockId" style="color: white;border-color:#EE9D01;background-color:#EE9D01;width:100%;font-size:0.8rem">
                    <i class="fas fa-spinner   fa-spin "></i> 
                </button>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column  text-sm" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
