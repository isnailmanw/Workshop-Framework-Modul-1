@extends('layouts.master')

@section('title', 'Edit Kategori')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Kategori</h4>

            <form action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST" id="formEditKategori">

                @csrf
                @method('PUT')

                <div class="form-group">

                    <label>Nama Kategori</label>

                    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" class="form-control"
                        required>

                </div>

                <button type="button" id="btnUpdateKategori" class="btn btn-success mt-3">
                    Update
                </button>

                <a href="{{ route('kategori.index') }}" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection


@section('js-page')

    <script>

        document.getElementById("btnUpdateKategori").onclick = function () {

            let form = document.getElementById("formEditKategori");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let btn = document.getElementById("btnUpdateKategori");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            form.submit();

        }

    </script>

@endsection