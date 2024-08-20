@extends('admin.layouts.app')
@section('title', 'List Users')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-body">
            <h4 class="section-title">Pengguna</h4>
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
                                        <div class="">
                                            <a class="btn btn-icon icon-left btn-ungu"
                                                href="{{ route('user.create') }}">Tambah</a>
                                        </div>
                                    </div>
                                    <div class="col-8 col-md-4 ms-auto">
                                        <form id="search" method="GET" action="{{ route('user.index') }}">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" id="name"
                                                    placeholder="cari...">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Tanggal Dibuat</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                            @foreach ($users as $key => $user)
                                                <tr class="align-middle">
                                                    <td class="text-center">
                                                        {{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}
                                                    </td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $user->role == 1 ? 'bg-danger' : 'bg-primary' }}">
                                                            {{ $user->role == 1 ? 'Admin' : 'Karyawan' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end">
                                                            <a href="{{ route('user.edit', $user->id) }}"
                                                                class="btn btn-sm btn-oren btn-icon me-2"><i
                                                                    class="fa fa-edit"></i>
                                                                Ubah</a>
                                                            <form action="{{ route('user.destroy', $user->id) }}"
                                                                method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">
                                                                <button class="btn btn-sm btn-danger btn-icon "><i
                                                                        class="fa fa-trash"></i> Hapus </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
