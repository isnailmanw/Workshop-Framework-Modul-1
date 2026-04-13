@extends('layouts.master')

@section('content')

    <div class="container-fluid mt-4">

        <h3 class="mb-4">✏️ Edit Customer</h3>

        <div class="card p-4 shadow rounded-4">

            <form method="POST" action="/customer/update/{{ $customer->id }}">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ $customer->nama }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ $customer->alamat }}">
                </div>

                <div class="mb-3">
                    <label>Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" value="{{ $customer->provinsi }}">
                </div>

                <div class="mb-3">
                    <label>Kota</label>
                    <input type="text" name="kota" class="form-control" value="{{ $customer->kota }}">
                </div>

                <div class="mb-3">
                    <label>Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ $customer->kecamatan }}">
                </div>

                <div class="mb-3">
                    <label>Kodepos</label>
                    <input type="text" name="kodepos" class="form-control" value="{{ $customer->kodepos }}">
                </div>

                <button class="btn btn-success">💾 Update</button>

            </form>

        </div>

    </div>

@endsection