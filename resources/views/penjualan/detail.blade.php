@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Detail Penjualan</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <h5>ID Penjualan : {{ $header->id_penjualan }}</h5>
            <h5>Tanggal : {{ $header->tanggal }}</h5>
            <h5>Total : {{ $header->total }}</h5>

            <br>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($detail as $d)

                        <tr>

                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->harga }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td>{{ $d->subtotal }}</td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <button class="btn btn-gradient-primary btn-kembali" onclick="window.location='{{ route('penjualan.index') }}'">

                <i class="mdi mdi-arrow-left"></i> Kembali

            </button>

        </div>
    </div>

@endsection