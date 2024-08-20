@extends('admin.layouts.app')
@section('title', 'Edit Galeri')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-body">
            <h4 class="section-title">Ubah Galeri</h4>
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
                                </div>
                            </div>
                            <form method="post" action="{{ route('galeri.update', $galeri) }}"
                                enctype="multipart/form-data">
                                @method('patch')
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="foto" class="form-label">Ganti Gambar</label>
                                            <input type="file" class="form-control" id="foto" name="foto">
                                            @error('foto')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer float-end">
                                    <div>
                                        <button type="submit" class="btn btn-icon icon-left btn-ungu">Simpan</button>
                                        <a class="btn btn-secondary" href="{{ route('galeri.index') }}">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
