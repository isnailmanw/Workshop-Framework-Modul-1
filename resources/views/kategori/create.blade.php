@extends('layouts.master')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Tambah Kategori</h4>

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" required>
                </div>

                <button class="btn btn-success mt-3">Simpan</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>

        </div>
    </div>

@endsection