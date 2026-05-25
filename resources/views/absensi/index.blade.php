@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="page-header">

            <h3 class="page-title">

                <span class="page-title-icon bg-gradient-primary text-white me-2">

                    <i class="mdi mdi-history"></i>

                </span>

                Riwayat Absensi NFC

            </h3>

        </div>

        <div class="row">

            <div class="col-12 grid-margin">

                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title mb-4">

                            Data Absensi Mahasiswa

                        </h4>

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead>

                                    <tr>

                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Prodi</th>
                                        <th>Serial Number</th>
                                        <th>Waktu Scan</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($absensis as $item)

                                        <tr>

                                            <td>
                                                {{ $loop->iteration }}
                                            </td>

                                            <td>
                                                {{ $item->nama }}
                                            </td>

                                            <td>
                                                {{ $item->nim }}
                                            </td>

                                            <td>
                                                {{ $item->prodi }}
                                            </td>

                                            <td>
                                                {{ $item->serial_number }}
                                            </td>

                                            <td>

                                                <span class="badge bg-gradient-success">

                                                    {{ $item->waktu_scan }}

                                                </span>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="6" class="text-center">

                                                Belum ada data absensi

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection