@extends('karyawan.layouts.app')
@section('title', 'Data Reservasi')
@section('content')
<!-- Main Content -->
<section class="section">
    <div class="section-body">
        <h4 class="section-title">Data Reservasi</h4>
        <div class="row">
            <div class="col-12">
                @include('karyawan.layouts.alert')
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
                                    <form id="filter" method="GET" action="{{ route('karyawan.reservasi.index') }}">
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
                                    <form id="search" method="GET" action="{{ route('karyawan.reservasi.index') }}">
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
                                            <th>Kode Pemesanan</th>
                                            <th>Nama</th>
                                            <th>Tanggal Pemesanan</th>
                                            <th>Tanggal Kedatangan</th>
                                            <th>Status</th>
                                            <th>Bukti Pembayaran</th>
                                            @if ($reservasis->contains('status', 2))
                                                <th>Verifikasi Bukti pembayaran</th>
                                            @endif
                                            <th>Rincian Pemesanan</th>
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
                                                    $text = 'Belum upload';
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
                                                            <form class="me-2" action="{{ route('karyawan.reservasi.proses', $reservasi->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="POST">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <button class="btn btn-sm btn-success btn-icon" type="submit"><i class="fa fa-check"> Valid</i></button>
                                                            </form>
                                                            <form class="me-2" action="{{ route('karyawan.reservasi.proses_upload_ulang', $reservasi->id) }}" method="POST">
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
                                                        <button data-reservasi="{{ json_encode($reservasi) }}" class="btn btn-sm btn-oren btn-icon me-2 btn-lihat" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fa fa-eye"></i></button>
                                                        <a href="{{ route('karyawan.reservasi.cetak_invoice', ['kode' => $reservasi->kode]) }}" class="btn btn-sm btn-oren btn-info btn-icon ms-2" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                                        <form action="{{ route('karyawan.reservasi.destroy', $reservasi->id) }}" method="POST" style="margin-left: 10px;">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button class="btn btn-sm btn-danger btn-icon"><i class="fa fa-trash"></i></button>
                                                        </form>
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
<!-- Modal -->
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

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Rincian Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Kode Pemesanan:</strong> <span id="modalKode"></span></p>
                <p><strong>Nama:</strong> <span id="modalNama"></span></p>
                <p><strong>No HP:</strong> <span id="modalNoHP"></span></p>
                <p><strong>Total:</strong> <span id="modalTotal"></span></p>
                <p><strong>Tanggal Pemesanan:</strong> <span id="modalTanggalPemesanan"></span></p>
                <p><strong>Tanggal Kedatangan:</strong> <span id="modalTanggalKedatangan"></span></p>
                <p><strong>Keperluan:</strong> <span id="modalKeperluan"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
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

        // Helper function to format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Helper function to format date
        function formatDate(dateString) {
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        // When the 'Lihat' button for details is clicked, fetch the details from 'data-reservasi' attribute and set it in the modal
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var reservasi = button.data('reservasi'); // Get the reservasi data from the 'data-reservasi' attribute of the button
            
            $('#modalKode').text(reservasi.kode);
            $('#modalNama').text(reservasi.nama);
            $('#modalNoHP').text(reservasi.no_hp);
            $('#modalTotal').text(formatCurrency(reservasi.total));
            $('#modalTanggalPemesanan').text(formatDate(reservasi.created_at));
            $('#modalTanggalKedatangan').text(formatDate(reservasi.tanggal));
            $('#modalKeperluan').text(reservasi.keperluan);
            
            // Translate status
            var statusText = '';
            if (reservasi.status == 0) {
                statusText = 'Menunggu Pembayaran';
            } else if (reservasi.status == 1) {
                statusText = 'Berhasil';
            } else if (reservasi.status == 2) {
                statusText = 'Belum Diverifikasi';
            } else if (reservasi.status == 4) {
                statusText = 'Belum upload';
            } else if (reservasi.status == 3) {
                statusText = 'Batal';
            }
            
            $('#modalStatus').text(statusText);
        });
    });
</script>
@endpush