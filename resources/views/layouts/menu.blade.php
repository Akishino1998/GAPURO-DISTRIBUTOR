<style>
    .nav-link {
        border-radius: 20px !important;
    }
</style>
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"dashboard")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"dashboard")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('dashboard') }}" class="nav-link  {{ (request()->routeIs('dashboard')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>
                Dashboard
            </p>
        </a>
    </li> 
@endif
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"barang.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"barang.index")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('barang.index') }}" class="nav-link  {{ (request()->routeIs('barang*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
                Barang
            </p>
        </a>
    </li> 
@endif

@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"toko.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"toko.index")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('toko.index') }}" class="nav-link  {{ (request()->routeIs('toko*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-store"></i>
            <p>
                Toko
            </p>
        </a>
    </li>
@endif

@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"konsumen.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"konsumen.index")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('konsumen.index') }}" class="nav-link  {{ (request()->routeIs('konsumen*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Konsumen
            </p>
        </a>
    </li>
@endif
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"pemesanan.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"pemesanan.index")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('pemesanan.index') }}" class="nav-link  {{ (request()->routeIs('pemesanan*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-signature"></i>
            <p>
                Pemesanan 
            </p>
        </a>
    </li>
@endif
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"admin.pemesanan.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"admin.pemesanan.index")->first()->id:"")->COUNT()>0 )
    <li class="nav-item mt-1">
        <a href="{{ route('admin.pemesanan.index') }}" class="nav-link  {{ (request()->routeIs('admin.pemesanan*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-signature"></i>
            <p>
                Pemesanan
            </p>
        </a>
    </li>
@endif
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"admin.master")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"admin.master")->first()->id:"")->COUNT()>0 )
    <li class="nav-item  {{ (request()->routeIs('admin.master*')) ? 'menu-open' : '' }}  mt-1">
        <a href="#" class="nav-link {{ (request()->routeIs('admin.master*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Invoice
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"admin.master.user.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"admin.master.user.index")->first()->id:"")->COUNT()>0 )
                <li class="nav-item">
                    <a href="{{ route('admin.master.user.index') }}" class="nav-link {{ (request()->routeIs('admin.master.user*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Semua</p> 
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('admin.master.merk.index') }}" class="nav-link {{ (request()->routeIs('admin.master.merk*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Konsumen</p> 
                </a>
            </li>
        </ul>
    </li>
@endif
@if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"admin.master")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"admin.master")->first()->id:"")->COUNT()>0 )
    <li class="nav-item  {{ (request()->routeIs('admin.master*')) ? 'menu-open' : '' }}  mt-1">
        <a href="#" class="nav-link {{ (request()->routeIs('admin.master*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Master
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            @if (Auth::user()->Role->RolePermission->where('id_permission',($providerPermission->where("route_name",'LIKE',"admin.master.user.index")->COUNT()>0)?$providerPermission->where("route_name",'LIKE',"admin.master.user.index")->first()->id:"")->COUNT()>0 )
                <li class="nav-item">
                    <a href="{{ route('admin.master.user.index') }}" class="nav-link {{ (request()->routeIs('admin.master.user*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Pengguna</p> 
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a href="{{ route('admin.master.merk.index') }}" class="nav-link {{ (request()->routeIs('admin.master.merk*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Merk</p> 
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.master.kategori.index') }}" class="nav-link {{ (request()->routeIs('admin.master.kategori*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Kategori</p> 
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.master.satuan.index') }}" class="nav-link {{ (request()->routeIs('admin.master.satuan*')) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Satuan</p> 
                </a>
            </li>
        </ul>
    </li>
@endif