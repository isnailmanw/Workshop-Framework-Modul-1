@extends('layouts.master')

@section('title', 'Edit Buku')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Buku</h4>

            <form action="{{ route('buku.update', $buku->idbuku) }}" method="POST" id="formEditBuku">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Kode</label>

                    <input type="text" name="kode" value="{{ $buku->kode }}" class="form-control" required>

                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" value="{{ $buku->pengarang }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Kategori</label>

                    <select name="idkategori" class="form-control" required>

                        @foreach($kategori as $k)

                            <option value="{{ $k->idkategori }}" {{ $buku->idkategori == $k->idkategori ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <button type="button" id="btnUpdateBuku" class="btn btn-success mt-3">
                    Update
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

        document.getElementById("btnUpdateBuku").onclick = function () {

            let form = document.getElementById("formEditBuku");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let btn = document.getElementById("btnUpdateBuku");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            form.submit();

        }

    </script>

@endsection