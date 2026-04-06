@extends('layouts.app')

@section('content')

    <div class="container mt-4">

        <a href="/vendor/dashboard" class="btn btn-secondary mb-3">
            ⬅ Kembali ke Dashboard
        </a>

        <h3 class="mb-3">Tambah Menu</h3>

        <!-- FORM -->
        <form action="{{ isset($menu) ? '/menu/update/' . $menu->id : '/menu/store' }}" method="POST" id="formMenu">
            @csrf

            <div class="mb-3">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" value="{{ $menu->harga ?? '' }}" required>
            </div>

            <button class="btn btn-primary" id="btnSubmit">
                💾 Simpan
            </button>

            <!-- SPINNER -->
            <div id="loading" style="display:none;">
                ⏳ Menyimpan...
            </div>

        </form>

        <hr>

        <!-- LIST MENU -->
        <h4>Daftar Menu</h4>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                @foreach($menus as $m)
                    <tr>
                        <td>{{ $m->nama_menu }}</td>
                        <td>Rp {{ number_format($m->harga) }}</td>
                        <td>
                            <a href="/menu/edit/{{ $m->id }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/menu/delete/{{ $m->id }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus menu?')">Hapus</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <!-- SCRIPT SPINNER -->
    <script>
        document.getElementById('formMenu').addEventListener('submit', function () {
            document.getElementById('btnSubmit').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
        });
    </script>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

@endsection