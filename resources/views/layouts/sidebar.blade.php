<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- ================= PROFILE ================= --}}
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                </div>

                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        {{ Auth::user()->name ?? 'User' }}
                    </span>
                    <span class="text-secondary text-small">
                        Administrator
                    </span>
                </div>

                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>


        {{-- DASHBOARD --}}
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="/dashboard">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        {{-- KATEGORI --}}
        <li class="nav-item {{ request()->is('kategori') || request()->is('kategori/*') ? 'active' : '' }}">
            <a class="nav-link" href="/kategori">
                <span class="menu-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        {{-- BUKU --}}
        <li class="nav-item {{ request()->is('buku') || request()->is('buku/*') ? 'active' : '' }}">
            <a class="nav-link" href="/buku">
                <span class="menu-title">Buku</span>
                <i class="mdi mdi-book menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link" onclick="togglePdfMenu()">
                📥 Download PDF
            </a>

            <ul id="pdfMenu" class="submenu">
                <li><a href="/pdf-sertifikat">📜 Sertifikat</a></li>
                <li><a href="/pdf-surat">📄 Surat</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/tagharga">
                <span class="menu-title">Tag Harga</span>
                <i class="mdi mdi-tag menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/modul-html">
                Modul HTML Table
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/modul-datatable">
                Modul DataTables
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="/select-kota">
                Modul Select Kota
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/week4') }}">
                <span class="menu-title">AJAX Demo</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('wilayah.ajax') }}">
                Wilayah - AJAX
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('wilayah.axios') }}">
                Wilayah AXIOS
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('pos.index') }}">
                POS AJAX
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="menu-icon mdi mdi-receipt"></i>
                <span class="menu-title">Riwayat Penjualan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('pos.axios') }}">
                <span class="menu-title">POS Axios</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="menu-icon mdi mdi-receipt"></i>
                <span class="menu-title">Riwayat Penjualan</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="/vendor/create" class="nav-link">
                ➕ Tambah Vendor
            </a>
        </li>

    </ul>
</nav>