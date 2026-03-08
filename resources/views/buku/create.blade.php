@extends('layouts.master')

@section('title', 'Tambah Buku')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Tambah Buku</h4>

            <form action="{{ route('buku.store') }}" method="POST" id="formBuku">
                @csrf

                <div class="form-group">
                    <label>Kode</label>
                    <input type="text" name="kode" class="form-control" required>

                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="idkategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>

                        @foreach($kategori as $k)
                            <option value="{{ $k->idkategori }}">
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <button type="button" id="btnSimpanBuku" class="btn btn-success mt-3">
                    Simpan
                </button>

                <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </form>

        </div>
    </div>

@endsection


@section('js-page')

    <script>

        document.getElementById("btnSimpanBuku").onclick = function () {

            let form = document.getElementById("formBuku");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let btn = document.getElementById("btnSimpanBuku");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            form.submit();

        }

    </script>

@endsection