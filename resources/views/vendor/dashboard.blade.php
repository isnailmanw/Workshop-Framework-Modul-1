@extends('layouts.app')

@section('content')

    <div class="container text-center mt-5">

        <h2 class="mb-4">Dashboard Vendor</h2>

        <div class="d-flex justify-content-center gap-4">

            <a href="/menu/create" class="btn btn-primary btn-lg">
                ➕ Tambah Menu
            </a>

            <a href="/vendor" class="btn btn-success btn-lg">
                📋 Lihat Pesanan
            </a>

        </div>

    </div>

@endsection