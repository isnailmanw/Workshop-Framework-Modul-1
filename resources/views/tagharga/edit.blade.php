@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">
            Edit Tag Harga
        </h3>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="/tagharga/update/{{$data->id_barang}}" method="POST" id="formTagHarga">

                @csrf

                <div class="form-group">

                    <label>Nama Barang</label>

                    <input type="text" name="nama_barang" value="{{$data->nama_barang}}" class="form-control" required>

                </div>

                <div class="form-group">

                    <label>Harga</label>

                    <input type="number" name="harga" value="{{$data->harga}}" class="form-control" required>

                </div>

                <button type="button" id="btnUpdateTagHarga" class="btn btn-primary">
                    Update
                </button>

                <a href="/tagharga" class="btn btn-light">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection


@section('js-page')

    <script>

        document.getElementById("btnUpdateTagHarga").onclick = function () {

            let form = document.getElementById("formTagHarga");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let btn = document.getElementById("btnUpdateTagHarga");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            form.submit();

        }

    </script>

@endsection