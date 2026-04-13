@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">Data Tag Harga</h3>
        </div>

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Daftar Barang</h4>

                <a href="/tagharga/create" class="btn btn-gradient-primary mb-3">
                    Tambah Data
                </a>

                <form action="/tagharga/cetak" method="POST">
                    @csrf

                    <div class="row mb-4">

                        <div class="col-md-2">
                            <label>Posisi X</label>
                            <input type="number" name="x" class="form-control" min="1" max="5" required>
                        </div>

                        <div class="col-md-2">
                            <label>Posisi Y</label>
                            <input type="number" name="y" class="form-control" min="1" max="8" required>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success">
                                Cetak PDF
                            </button>
                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-striped" id="datatableTagHarga">

                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($data as $d)

                                    <tr>

                                        <!-- ✅ CHECKBOX FIX -->
                                        <td>
                                            <input type="checkbox" name="pilih[]" value="{{ $d->id }}">
                                        </td>

                                        <td>{{ $d->id }}</td>

                                        <!-- ✅ NAMA BISA DIKLIK -->
                                        <td>
                                            <span class="nama-click text-primary" data-id="{{ $d->id }}"
                                                data-nama="{{ $d->nama }}" data-harga="{{ $d->harga }}" style="cursor:pointer;">
                                                {{ $d->nama }}
                                            </span>
                                        </td>

                                        <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>

                                        <td>
                                            <a href="/tagharga/edit/{{ $d->id }}" class="btn btn-warning btn-sm">
                                                Edit
                                            </a>

                                            <a href="/tagharga/delete/{{ $d->id }}" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                Delete
                                            </a>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </form>

            </div>
        </div>

    </div>

    {{-- MODAL --}}
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editId">

                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" id="editNama" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" id="editHarga" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button id="btnUbah" class="btn btn-warning">Ubah</button>
                    <button id="btnHapus" class="btn btn-danger">Hapus</button>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('js-page')

    <script>

        $(document).ready(function () {

            $('#datatableTagHarga').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                responsive: true
            });

            // ✅ CLICK HANYA DI NAMA
            $('.nama-click').click(function () {

                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let harga = $(this).data('harga');

                $('#editId').val(id);
                $('#editNama').val(nama);
                $('#editHarga').val(harga);

                $('#modalEdit').modal('show');
            });

        });

    </script>

@endsection