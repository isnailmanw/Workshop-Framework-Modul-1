@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Riwayat Penjualan</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($data as $d)

                        <tr>

                            <td>{{ $d->id_penjualan }}</td>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->total }}</td>

                            <td>

                                <button class="btn btn-gradient-primary btn-kembali"
                                    onclick="window.location='{{ route('penjualan.detail', $d->id_penjualan) }}'">

                                    Detail

                                </button>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

@endsection