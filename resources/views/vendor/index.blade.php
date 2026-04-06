@extends('layouts.app')

@section('content')

    <div class="container py-4">

        <a href="/vendor/dashboard" class="btn btn-secondary mb-3">
            ⬅ Kembali ke Dashboard
        </a>

        <h3 class="mb-4">📋 Data Pesanan</h3>

        <a href="/vendor" class="btn btn-secondary mb-3">Semua</a>
        <a href="/vendor/lunas" class="btn btn-success mb-3">Lunas</a>

        <div class="card">
            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($orders as $o)
                            <tr>
                                <td>#{{ $o->id }}</td>
                                <td>{{ $o->nama_customer }}</td>
                                <td>Rp {{ number_format($o->total) }}</td>
                                <td>
                                    @if($o->status_pembayaran == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <ul>
                                        @foreach($o->details as $d)
                                            <li>{{ $d->menu->nama_menu }} ({{ $d->qty }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    </div>

@endsection