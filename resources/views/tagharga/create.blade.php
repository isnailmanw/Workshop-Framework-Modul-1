@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">
            Tambah Tag Harga
        </h3>
    </div>


    <div class="card">
        <div class="card-body">

            <form action="/tagharga/store" method="POST">

                @csrf

                <div class="form-group">

                    <label>Nama Barang</label>

                    <input type="text" name="nama_barang" class="form-control">

                </div>


                <div class="form-group">

                    <label>Harga</label>

                    <input type="number" name="harga" class="form-control">

                </div>


                <button class="btn btn-primary">

                    Simpan

                </button>

                <a href="/tagharga" class="btn btn-light">

                    Kembali

                </a>

            </form>

        </div>
    </div>

@endsection