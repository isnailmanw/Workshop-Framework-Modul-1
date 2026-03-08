@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                Tambah Tag Harga
            </h3>
        </div>

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Form Tambah Barang</h4>

                <form action="/tagharga/store" method="POST" id="formTagHarga">
                    @csrf

                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga" required>
                    </div>

                    <button type="button" id="btnSimpan" class="btn btn-gradient-primary me-2">
                        Simpan
                    </button>

                    <a href="/tagharga" class="btn btn-light">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </div>

@endsection

@section('js-page')

    <script>

        document.getElementById("btnSimpan").onclick = function () {

            let form = document.getElementById("formTagHarga");

            if (!form.checkValidity()) {

                form.reportValidity();
                return;

            }

            let btn = document.getElementById("btnSimpan");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            form.submit();

        };

    </script>

@endsection