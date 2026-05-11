@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">

                <div class="card shadow-sm border-0 rounded-4">

                    <!-- HEADER -->
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>

                                <h2 class="font-weight-bold text-dark mb-1">
                                    Kunjungan Toko
                                </h2>

                                <p class="text-muted mb-0">
                                    Data lokasi toko untuk validasi kunjungan sales
                                </p>

                            </div>

                            <a href="/tambah-toko" class="btn btn-gradient-primary btn-rounded btn-fw">

                                + Tambah Toko

                            </a>

                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive">

                            <table class="table table-hover">

                                <thead class="bg-light">

                                    <tr>

                                        <th class="text-center">
                                            No
                                        </th>

                                        <th>
                                            Barcode
                                        </th>

                                        <th>
                                            Nama Toko
                                        </th>

                                        <th>
                                            Latitude
                                        </th>

                                        <th>
                                            Longitude
                                        </th>

                                        <th class="text-center">
                                            Accuracy
                                        </th>

                                        <th class="text-center">
                                            QR Code
                                        </th>

                                        <th class="text-center">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($toko as $index => $item)

                                        <tr>

                                            <td class="text-center">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <strong>
                                                    {{ $item->barcode }}
                                                </strong>
                                            </td>

                                            <td>
                                                {{ $item->nama_toko }}
                                            </td>

                                            <td>
                                                {{ $item->latitude }}
                                            </td>

                                            <td>
                                                {{ $item->longitude }}
                                            </td>

                                            <td class="text-center">

                                                <label class="badge badge-success px-3 py-2">

                                                    {{ $item->accuracy }} m

                                                </label>

                                            </td>

                                            <td class="text-center">

                                                <a href="/qrcode/{{ $item->id }}" class="btn btn-gradient-info btn-sm">

                                                    <i class="mdi mdi-qrcode"></i>

                                                </a>

                                            </td>

                                            <td class="text-center">



                                                <button class="btn btn-gradient-primary btn-sm">

                                                    <i class="mdi mdi-pencil"></i>

                                                </button>

                                                <button class="btn btn-gradient-danger btn-sm">

                                                    <i class="mdi mdi-delete"></i>

                                                </button>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="7" class="text-center text-muted py-4">

                                                Data toko belum tersedia

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <!-- FOOTER TABLE -->
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <p class="text-muted mb-0">

                                Menampilkan {{ count($toko) }} data

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection