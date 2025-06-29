<!-- resources/views/layouts/sidebar.blade.php -->
<div class="sidebar p-3">
    <!-- Logo/Brand -->
    <div class="text-center mb-4">
        <h4 class="fw-bold">
            <i class="bi-heart-pulse"></i>
            Manajemen Apotek
        </h4>
        <small class="text-light opacity-75">Inventaris & Penjualan</small>
    </div>

    <!-- User Info -->
    <div class="bg-white bg-opacity-10 rounded p-3 mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                <small class="opacity-75">
                    <i class="bi bi-circle-fill text-success me-1" style="font-size: 0.5rem;"></i>
                    {{ ucfirst(auth()->user()->role) }}
                </small>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav flex-column">
        <!-- Dashboard -->
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>

        <!-- Divider -->
        <hr class="text-white-50 my-3">

        <!-- Master Data -->
        @if(auth()->user()->role === 'admin')
        <div class="nav-item">
            <div class="text-white-50 small fw-semibold mb-2 px-3">MASTER DATA</div>
            <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                <i class="bi bi-tags me-2"></i>
                Kategori Obat
            </a>
            <a class="nav-link {{ request()->routeIs('obat.*') ? 'active' : '' }}" href="{{ route('obat.index') }}">
                <i class="bi bi-capsule me-2"></i>
                Data Obat
            </a>
        </div>
        <hr class="text-white-50 my-3">
        @endif

        <!-- Transaksi -->
        <div class="nav-item">
            <div class="text-white-50 small fw-semibold mb-2 px-3">TRANSAKSI</div>
            <a class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : '' }}" href="{{ route('transaksi.create') }}">
                <i class="bi bi-plus-circle me-2"></i>
                Penjualan Baru
            </a>
            <a class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                <i class="bi bi-receipt me-2"></i>
                Riwayat Transaksi
            </a>
        </div>

        <!-- Divider -->
        @if(auth()->user()->role === 'admin')
        <hr class="text-white-50 my-3">

        <!-- Laporan (hanya admin) -->
        <div class="nav-item">
            <div class="text-white-50 small fw-semibold mb-2 px-3">LAPORAN</div>
            <a class="nav-link" href="{{ route('transaksi.export.pdf') }}" target="_blank">
                <i class="bi bi-file-earmark-pdf me-2"></i>
                Export PDF
            </a>
            <a class="nav-link" href="{{ route('transaksi.export.excel') }}">
                <i class="bi bi-file-earmark-excel me-2"></i>
                Export Excel
            </a>
        </div>
        @endif
    </nav>

    <!-- Bottom Info -->
    <div class="position-absolute bottom-0 start-0 end-0 p-3">
        <div class="text-center">
            <small class="text-white-50">
                © 2024 Apotek System<br>
                Version 1.0
            </small>
        </div>
    </div>
</div>