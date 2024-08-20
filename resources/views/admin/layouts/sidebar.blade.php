<div class="col-md-3 ps-0 pe-0 bg-ungu2 sidebar-new">
    <div class="d-flex flex-column flex-shrink-0 p-4 bg-ungu2 text-white">
        <div class="d-flex flex-column align-items-start mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
            <span>Pengguna : {{ auth()->user()->username }}</span>
            <span>Nama : {{ auth()->user()->name }}</span>
        </div>
        <hr />
        @php
            $route_name = \Route::currentRouteName();
        @endphp
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <a href="{{ url('admin/home') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'admin.home' ? 'active' : '' }}">
                    <i class="fa fa-tachometer me-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('admin/reservasi') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'admin.reservasi.index' ? 'active' : '' }}">
                    <i class="fa fa-calendar me-2"></i>
                    Reservasi
                </a>
            </li>
            <li>
                <a href="{{ url('admin/pembatalan') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'admin.pembatalan.index' ? 'active' : '' }}">
                    <i class="fa fa-calendar-times-o me-2"></i>
                    Pembatalan
                </a>
            </li>
            <li>
                <a href="{{ url('admin/laporan') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'admin.cetaklaporan' ? 'active' : '' }}">
                    <i class="fa fa-print me-2"></i>
                    Cetak
                </a>
            </li>
            <hr /> <!-- Tambahkan garis di sini -->
            <li>
                <a href="{{ url('admin/user') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'user.index' ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i>
                    Pengguna
                </a>
            </li>
            <li>
                <a href="{{ url('admin/gedung') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'gedung.index' ? 'active' : '' }}">
                    <i class="fa fa-building me-2"></i>
                    Gedung
                </a>
            </li>
            <li>
                <a href="{{ url('admin/galeri') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'galeri.index' ? 'active' : '' }}">
                    <i class="fa fa-picture-o me-2"></i>
                    Galeri
                </a>
            </li>
            <li>
                <a href="{{ url('admin/bank') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'bank.index' ? 'active' : '' }}">
                    <i class="fa fa-university me-2"></i>
                    Bank
                </a>
            </li>
            <li>
                <a href="{{ url('admin/rekening') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'rekening.index' ? 'active' : '' }}">
                    <i class="fa fa-credit-card me-2"></i>
                    Rekening
                </a>
            </li>
            <hr />
            <!-- <li>
                <a href="{{ url('admin/syarat-ketentuan') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'sk.website' ? 'active' : '' }}">
                    <i class="fa fa-balance-scale me-2"></i>
                    Syarat & Ketentuan
                </a>
            </li> -->
            <li>
                <a href="{{ url('admin/website') }}"
                    class="btn btn-toggle align-items-center rounded {{ $route_name == 'admin.website' ? 'active' : '' }}">
                    <i class="fa fa-cogs me-2"></i>
                    Pengaturan Website
                </a>
            </li>
        </ul>
    </div>
</div>