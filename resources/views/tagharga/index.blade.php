@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">
            Data Tag Harga
        </h3>
    </div>


    <div class="card">
        <div class="card-body">


            <a href="/tagharga/create" class="btn btn-primary mb-3">
                Tambah Data
            </a>


            <form action="/tagharga/cetak" method="POST">

                @csrf


                <div class="row mb-3">

                    <div class="col-md-2">

                        <label>Posisi X</label>

                        <input type="number" name="x" class="form-control" min="1" max="5" required>

                    </div>


                    <div class="col-md-2">

                        <label>Posisi Y</label>

                        <input type="number" name="y" class="form-control" min="1" max="8" required>

                    </div>


                    <div class="col-md-3 mt-4">

                        <button class="btn btn-success">

                            Cetak PDF

                        </button>

                    </div>

                </div>



                <div class="table-responsive">


                    <table class="table table-bordered" id="datatableTagHarga">

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


                                    <td>

                                        <input type="checkbox" name="pilih[]" value="{{$d->id_barang}}">

                                    </td>


                                    <td>{{$d->id_barang}}</td>

                                    <td>{{$d->nama_barang}}</td>

                                    <td>Rp {{$d->harga}}</td>


                                    <td>

                                        <a href="/tagharga/edit/{{$d->id_barang}}" class="btn btn-warning btn-sm">

                                            Edit

                                        </a>


                                        <a href="/tagharga/delete/{{$d->id_barang}}" class="btn btn-danger btn-sm">

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

@endsection


@section('js-page')

    <script>

        $(document).ready(function () {

            $('#datatableTagHarga').DataTable({
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
            });

        });

    </script>

@endsection