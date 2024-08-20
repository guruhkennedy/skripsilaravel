@extends('layouts.app')
@section('title', 'Pesan')
@section('content')
    <!-- start page title section -->
    <section class="page-title-section bg-img cover-background" data-overlay-dark="4" data-background="img/IMG_9306.jpg">
        <div class="container">
            <h1>Halaman Reservasi</h1>
            <br>
            <div class="container h-100">
                <div class="header-text text-center display-table h-100 ml-auto mr-auto">
                    <div class="display-table-cell vertical-align-bottom">
                        <div class="bg-white-opacity padding-40px-top padding-35px-bottom padding-40px-lr border-radius-3">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ingin mengubah tanggal?</label>
                                        <input type="text" name="tgl_display" placeholder="Pilih Tanggal" id="tgl_display" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 margin-15px-top">
                                    <form method="get" action="{{ url('cari') }}">
                                        @csrf
                                        <input type="hidden" name="date" id="date" value="{{ $date }}">
                                        <button type="submit" class="butn no-margin-bottom btn-block">Cari</button>
                                    </form>
                                </div>
                                @error('date')
                                    <small id="passwordHelp" class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title section -->

    <!-- start booking-form section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 sm-margin-50px-bottom">
                    <h4 class="text-uppercase letter-spacing-1 margin-30px-bottom font-size24">Form Reservasi</h4>
                    @error('msg')
                        <h6>{{ $message }}</h6>
                    @enderror
                    <form id="booking-form" method="post" action="{{ url('booking') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="title">*Titel</label>
                                        <select name="title" id="title">
                                            <option value="Bapak">Bapak</option>
                                            <option value="Ibu">Ibu</option>
                                        </select>
                                    </div>
                                    <div class="col-8">
                                        <label for="name">*Nama lengkap</label>
                                        <input id="name" placeholder="John Doe" type="text" name="nama" value="{{ old('nama') }}">
                                        @error('nama')
                                            <small id="passwordHelp" class="text-danger">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">*Email</label>
                                    <input id="email" name="email" placeholder="johndoe@gmail.com" type="email" value="{{ old('email') }}">
                                    @error('email')
                                        <small id="passwordHelp" class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">*Nomor Handphone</label>
                                    <input id="phone" placeholder="085156842765" type="number" name="no_hp" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <small id="passwordHelp" class="text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Gedung</label>
                                    <input class="form-control" type="text" value="{{ $gedung->nama }}" readonly>
                                    <input class="form-control" type="hidden" value="{{ $gedung->id }}" readonly name="gedung">
                                    <input class="form-control" type="hidden" value="{{ $gedung->harga }}" readonly name="total">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="keperluan">*Keperluan</label>
                                <select name="keperluan" id="keperluan">
                                    <option value="" selected disabled>- Pilih Keperluan -</option>
                                    <option value="Pernikahan" @if (old('keperluan') == 'Pernikahan') selected @endif>Pernikahan</option>
                                    <option value="Rapat" @if (old('keperluan') == 'Rapat') selected @endif>Rapat</option>
                                    <option value="Acara Sekolah" @if (old('keperluan') == 'Acara Sekolah') selected @endif>Acara Sekolah</option>
                                    <option value="Lainnya" @if (old('keperluan') == 'Lainnya') selected @endif>Lainnya</option>
                                </select>
                                @error('keperluan')
                                    <small id="passwordHelp" class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Tanggal</label>
                                    <input class="form-control" type="text" value="{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}" readonly name="display_date">
                                    <input class="form-control" type="hidden" value="{{ $date }}" name="date">
                                </div>
                            </div>
                            <div class="col-md-6 d-none" id="keperluan_lainnya">
                                <div class="form-group">
                                    <label for="keperluan_o">Keperluan Lainnya</label>
                                    <input class="form-control" type="text" name="keperluan_o">
                                </div>
                                @error('keperluan_o')
                                    <small id="passwordHelp" class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <br>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="termsCheckbox" name="terms">
                            <label class="form-check-label" for="termsCheckbox">
                                Saya telah menyetujui <a href="/syarat-ketentuan" target="blank" style="color: blue;">syarat dan ketentuan <a> reservasi gedung ini</a>
                            </label>
                            @error('terms')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 popular-things">
                    <div class="padding-30px-left sm-no-padding-left">
                        <h4 class="text-uppercase letter-spacing-1 margin-30px-bottom font-size24">Total Harga</h4>
                        <div class="theme-shadow border-radius-3 margin-30px-bottom">
                            <img src={{ asset('/img/produk/' . $gedung->foto) }} alt="{{ $gedung->nama }}" />
                            <div class="border-bottom padding-25px-all d-flex justify-content-between">
                                <h5 class="font-size17 no-margin-bottom">@currency($gedung->harga)</h5>
                                <ul class="rate no-margin-bottom">
                                </ul>
                            </div>
                            <div>
                                <div class="row align-items-center text-center padding-15px-tb">
                                    <div class="col-md-12">
                                        <button id="paymentButton" onclick="event.preventDefault(); document.getElementById('booking-form').submit();" class="butn">Lanjutkan ke pembayaran</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end booking-form section -->
@endsection

@push('customScript')
    <script>
        $(document).ready(function() {
            // Initialize datepicker
            $('#tgl_display').datepicker({
                dateFormat: 'dd MM yy',
                onSelect: function(dateText) {
                    var date = $(this).datepicker('getDate');
                    var yyyy = date.getFullYear();
                    var mm = ('0' + (date.getMonth() + 1)).slice(-2);
                    var dd = ('0' + date.getDate()).slice(-2);
                    var formattedDate = yyyy + '-' + mm + '-' + dd;
                    $('#date').val(formattedDate);
                }
            });

            // Show/hide additional purpose input
            if ($('#keperluan').val() == 'Lainnya') {
                $('#keperluan_lainnya').removeClass('d-none');
            } else {
                $('#keperluan_lainnya').addClass('d-none');
            }

            $('#keperluan').change(function() {
                if ($(this).val() == 'Lainnya') {
                    $('#keperluan_lainnya').removeClass('d-none');
                } else {
                    $('#keperluan_lainnya').addClass('d-none');
                }
            });
        });
    </script>
@endpush
