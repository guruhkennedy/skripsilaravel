@extends('admin.layouts.app')
@section('title', 'Cetak Laporan')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-body">
            <h4 class="section-title">Cetak Laporan</h4>
            <div class="row">
                <div class="col-12">
                    @include('admin.layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-body">
                                <form id="cetakLaporanForm">
                                    <div class="input-group mb-3">
                                        <label for="tglawal">Tanggal Pemesanan Awal &nbsp;</label>
                                        <br><input type="text" name="tglawal" id="tglawal" class="form-control" placeholder="Pilih Tanggal" required/>
                                    </div>
                                    <div class="input-group mb-3">
                                        <label for="tglakhir">Tanggal Pemesanan Akhir &nbsp;</label>
                                        <br><input type="text" name="tglakhir" id="tglakhir" class="form-control" placeholder="Pilih Tanggal" required/>
                                    </div>
                                    <div class="input-group mb-3">
                                        <a href="#" id="cetakButton" class="btn btn-primary col-md-12"> Cetak <i class="fa fa-print"></i></a>
                                    </div>
                                    <div id="error-message" class="text-danger"></div>
                                </form>
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
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
        locale: "id"
    });
    flatpickr("#tglakhir", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
        locale: "id"
    });

    document.getElementById('cetakButton').addEventListener('click', function(event) {
        event.preventDefault();
        var tglawal = document.getElementById('tglawal').value;
        var tglakhir = document.getElementById('tglakhir').value;
        var errorMessage = document.getElementById('error-message');

        if (!tglawal || !tglakhir) {
            errorMessage.textContent = "Harap isi tanggal awal dan akhir.";
        } else {
            errorMessage.textContent = "";
            var href = 'laporan/' + tglawal + '/' + tglakhir;
            this.setAttribute('href', href);
            window.open(href, '_blank');
        }
    });
</script>
@endpush