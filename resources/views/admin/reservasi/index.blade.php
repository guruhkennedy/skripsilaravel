@extends('admin.layouts.app')
@section('title', 'Data Reservasi')
@section('content')
<!-- Main Content -->
<section class="section">
    <div class="section-body">
        <h4 class="section-title">Data Reservasi</h4>
        <div class="row">
            <div class="col-12">
                @include('admin.layouts.alert')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-header-action">
                            <div class="row">
                                <div class="col-4">
                                    <!-- Filter form -->
                                    <form id="filter" method="GET" action="{{ route('admin.reservasi.index') }}">
                                        <div class="form-group">
                                            <select name="status" class="form-control" onchange="document.getElementById('filter').submit();">
                                                <option value="">Pilih Status</option>
                                                <option value="0">Semua</option>
                                                <option value="1">Berhasil</option>
                                                <option value="2">Belum Diverifikasi</option>
                                                <option value="4">Belum Upload</option>
                                                <option value="3">Batal</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-8 col-md-4 ms-auto">
                                    <form id="search" method="GET" action="{{ route('admin.reservasi.index') }}">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Cari Kode pemesanan...">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode Reservasi</th>
                                            <th>Nama</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Tanggal Kedatangan</th>
                                            <th>Status</th>
                                            <th>Bukti Pembayaran</th>
                                            @if ($reservasis->contains('status', 2))
                                                <th>Verifikasi Bukti Pembayaran</th>
                                            @endif
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservasis as $key => $reservasi)
                                            @php
                                                if ($reservasi->status == 0) {
                                                    $text = 'Menunggu Pembayaran';
                                                    $color = 'bg-primary';
                                                    $icon = 'far fa-hourglass';
                                                } elseif ($reservasi->status == 1) {
                                                    $text = 'Berhasil';
                                                    $color = 'bg-success';
                                                    $icon = 'far fa-check-circle';
                                                } elseif ($reservasi->status == 2) {
                                                    $text = 'Belum Diverifikasi';
                                                    $color = 'bg-warning';
                                                    $icon = 'far fa-clock';
                                                } elseif ($reservasi->status == 4) {
                                                    $text = 'Belum Upload';
                                                    $color = 'bg-dark';
                                                    $icon = 'far fa-clock';
                                                } elseif ($reservasi->status == 3) {
                                                    $text = 'Batal';
                                                    $color = 'bg-danger';
                                                    $icon = 'far fa-times-circle';
                                                }
                                            @endphp
                                            <tr class="align-middle">
                                                <td class="text-center">
                                                    {{ ($reservasis->currentPage() - 1) * $reservasis->perPage() + $key + 1 }}
                                                </td>
                                                <td>{{ $reservasi->kode }}</td>
                                                <td>{{ $reservasi->nama }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservasi->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reservasi->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                                <td><span class="badge {{ $color }}">{{ $text }}</span></td>
                                                <td>
                                                    @if ($reservasi->bukti_pembayaran)
                                                        <button data-url="{{ asset($reservasi->bukti_pembayaran) }}" class="btn btn-sm btn-oren btn-icon me-2" data-bs-toggle="modal" data-bs-target="#imageModal">
                                                            <i class="fa fa-image"></i> Lihat
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                @if ($reservasi->status == 2)
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end align-items-center">
                                                            <form class="me-2" action="{{ route('admin.reservasi.proses', $reservasi->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="POST">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button class="btn btn-sm btn-success btn-icon" type="submit"><i class="fa fa-check"> Valid</i></button>
                                                            </form>
                                                            <form class="me-2" action="{{ route('admin.reservasi.proses_upload_ulang', $reservasi->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="POST">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button class="btn btn-sm btn-success btn-icon" type="submit"><i class="fa fa-whatsapp"> Tidak</i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @elseif ($reservasis->contains('status', 2))
                                                    <td></td>
                                                @endif
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <a href="{{ route('admin.reservasi.cetak_invoice', ['kode' => $reservasi->kode]) }}" class="btn btn-sm btn-oren btn-info btn-icon me-2" target="_blank">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a>
                                                        {{-- Tombol Delete dikomentari --}}
                                                        {{-- @if ($reservasi->status != 1)
                                                            <form action="{{ route('admin.reservasi.destroy', $reservasi->id) }}" method="POST" style="margin-left: 10px;">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button class="btn btn-sm btn-danger btn-icon"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        @endif --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $reservasis->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- Modal untuk gambar bukti pembayaran -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" id="previewImage" class="img-fluid" alt="Preview Image" height="400">
            </div>
        </div>
    </div>
</div>
@endsection

@push('customScript')
<script>
    $(document).ready(function() {
        // When the 'Lihat' button is clicked, fetch the image source from 'data-url' attribute and set it as the preview image source
        $('#imageModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var imageSrc = button.data('url'); // Get the image source from the 'data-url' attribute of the button
            $('#previewImage').attr('src', imageSrc); // Set the 'src' attribute of the preview image
        });
    });
</script>
@endpush