@extends('karyawan.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-body">
            <h4 class="section-title">Dashboard</h4>
            <div class="row">
                <div class="col-12">
                    @include('karyawan.layouts.alert')
                </div>
            </div>
            <div class="main-content">
                    <div class="header-body">
                      <div class="row">
                        <div class="col-xl-4 col-lg-8">
                          <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <h5 class="card-title text-uppercase text-muted mb-0">Total Reservasi Hari ini</h5>
                                  <span class="h2 font-weight-bold mb-0">{{ $totalReservasiHariIni }}</span>
                                </div>
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                                    <i class="fas fa-calendar-day"></i>
                                  </div>
                                </div>
                              </div>
                            
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-8">
                          <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan Bulan Ini</h5>
                                  <span class="h2 font-weight-bold mb-0">Rp{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-coins"></i>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-xl-4 col-lg-8">
                          <div class="card card-stats mb-4 mb-xl-0">
                            <div class="card-body">
                              <div class="row">
                                <div class="col">
                                  <h5 class="card-title text-uppercase text-muted mb-0">Total Reservasi Bulan Ini</h5>
                                  <span class="h2 font-weight-bold mb-0"> {{ $totalReservasiBulanIni }}</span>
                                </div>
                                <div class="col-auto">
                                  <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                    <i class="fas fa-calendar-alt"></i>
                                  </div>
                                </div>
                              </div>
                        
                            </div>
                          </div>
                        </div>
                  </div>
                </div>
                <!-- Page content -->
              <br>
              <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Welcome Card -->
                                        <div class="card welcome-card">
                                            <div class="card-body text-center">
                                                <img src="/img/avatar.png" alt="User Image" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px;">
                                                <h2>Selamat datang, {{ Auth::user()->name }}!</h2>
                                                <p>Silahkan gunakan sistem ini dengan bijak</p>
                                            </div>
                                        </div>
                                        <!-- End Welcome Card -->

                                        <!-- User Information Table -->
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h4>Informasi Akun</h4>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-secondary table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Username</th>
                                                            <th>Jabatan</th>
                                                            <th>Tanggal Bergabung</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ Auth::user()->name }}</td>
                                                            <td>{{ Auth::user()->username }}</td>
                                                            <td>
                                                                @if (Auth::user()->role == 1)
                                                                    Admin
                                                                @elseif (Auth::user()->role == 0)
                                                                    Pengelola
                                                                @else
                                                                    Unknown
                                                                @endif
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End User Information Table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
    </section>
@endsection
