<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Home -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Home</span>
            </a>
        </li>
<!-- User Management -->
<li class="nav-item">
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
        <a class="nav-link" data-toggle="collapse" href="#user-management" aria-expanded="false" aria-controls="user-management">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">User Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="user-management">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('anggota.index') }}">Anggota</a>
                </li>
            </ul>
        </div>
    @endif
</li>

        <!-- Produk -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#produk-collapse" aria-expanded="false" aria-controls="produk-collapse">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">Produk</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="produk-collapse">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pinjaman.index') }}">Pinjam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('simpanan.index') }}">Simpanan</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
