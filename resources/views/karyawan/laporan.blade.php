@extends('karyawan.layouts.app')
@section('title', 'Cetak Laporan')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-body">
            <h4 class="section-title">Cetak Laporan</h4>
            <div class="row">
                <div class="col-12">
                    @include('karyawan.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class ="card-body">
                                <div class="input-group mb-3">
                                    <label for="label">Tanggal Pemesanan Awal &nbsp;</label>
                                    <br><input type="text" name="tglawal" id="tglawal" class="form-control" placeholder="Pilih Tanggal"/>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="label">Tanggal Pemesanan Akhir &nbsp;</label>
                                    <br><input type="text" name="tglakhir" id="tglakhir" class="form-control" placeholder="Pilih Tanggal"/>
                                </div>
                                    <div class="input-group mb-3">
                                        <a href="#" onclick="this.href='laporan/'+document.getElementById('tglawal').value + '/' +document.getElementById('tglakhir').value" target="blank" class="btn btn-primary col-md-12"> Cetak <i class="fa fa-print"></i></a>
                                    </div>
                        </div>
                        <div class="card-body">
                            <div class="container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('customScript')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    flatpickr("#tglawal", {
        locale: "id"
    });
    flatpickr("#tglakhir", {
        locale: "id"
    });
</script>
@endpush