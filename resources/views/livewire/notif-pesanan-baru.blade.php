<div wire:poll.10000ms>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.pemesanan.index') }}" role="button"  data-toggle="modal" data-target="#modalPemesananTerbaru">
            <i class="fas fa-box-open"></i>
            <span class="badge badge-danger navbar-badge">{{ COUNT($pemesanan) }}</span>
        </a>
    </li>
</div>
