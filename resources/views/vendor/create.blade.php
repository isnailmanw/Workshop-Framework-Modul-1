@extends('layouts.master')

@section('content')

    <div class="container py-4">

        <h3 class="mb-4">➕ Tambah Vendor</h3>

        {{-- 🔥 NOTIF ERROR --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 🔥 NOTIF SUCCESS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔥 FORM TAMBAH VENDOR --}}
        <div class="card mb-4">
            <div class="card-body">

                <form action="/vendor/store" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Vendor</label>
                        <input type="text" name="nama_vendor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-primary">
                        💾 Simpan
                    </button>

                    <a href="/dashboard" class="btn btn-secondary">
                        ← Kembali
                    </a>

                </form>

            </div>
        </div>

        {{-- 🔥 TABEL LIST VENDOR --}}
        <div class="card">
            <div class="card-body">

                <h5 class="mb-3">📋 Daftar Vendor</h5>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Vendor</th>
                            <th>Email</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($vendors as $v)
                            <tr>
                                <td>{{ $v->nama_vendor }}</td>
                                <td>{{ $v->user->email ?? '-' }}</td>
                                <td>

                                    {{-- ✏️ EDIT --}}
                                    <a href="/vendor/{{ $v->id }}/edit" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    {{-- 🗑️ DELETE --}}
                                    <form action="/vendor/{{ $v->id }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus vendor ini?')">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada vendor</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection