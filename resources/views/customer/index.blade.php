@extends('layouts.master')

@section('content')

    <div class="container-fluid mt-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">👤 Data Customer</h3>
                <p class="text-muted mb-0">Kelola data customer & foto</p>
            </div>

            <div class="d-flex gap-2">
                <a href="/customer/create1" class="btn btn-gradient-primary px-4">📷 Kamera</a>
                <a href="/customer/create2" class="btn btn-success px-4">📁 Upload</a>
            </div>
        </div>

        <!-- CARD -->
        <div class="card border-0 shadow-lg rounded-4">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle table-borderless">

                        <thead class="table-light text-center">
                            <tr>
                                <th style="width:180px;">Foto</th>
                                <th style="width:150px;">Nama</th>
                                <th style="min-width:350px;">Alamat</th>
                                <th style="width:200px;">Wilayah</th>
                                <th style="width:120px;">Kodepos</th>
                                <th style="width:120px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($data as $d)
                                <tr>

                                    <!-- FOTO FIX -->
                                    <td class="text-center">
                                        @if($d->foto_blob)
                                            <img src="{{ $d->foto_blob }}" class="foto-fix">
                                        @elseif($d->foto_path)
                                            <img src="{{ asset('storage/' . $d->foto_path) }}" class="foto-fix">
                                        @else
                                            <div class="text-muted small">No Image</div>
                                        @endif
                                    </td>

                                    <!-- NAMA -->
                                    <td class="fw-semibold text-center">
                                        {{ $d->nama }}
                                    </td>

                                    <!-- ALAMAT FIX -->
                                    <td class="alamat-fix">
                                        {{ $d->alamat ?? '-' }}
                                    </td>

                                    <!-- WILAYAH -->
                                    <td class="small wilayah-fix">
                                        {{ $d->kecamatan ?? '-' }}<br>
                                        {{ $d->kota ?? '-' }}<br>
                                        {{ $d->provinsi ?? '-' }}
                                    </td>

                                    <!-- KODEPOS -->
                                    <td class="text-center">
                                        {{ $d->kodepos ?? '-' }}
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="/customer/edit/{{ $d->id }}" class="btn btn-warning btn-sm">
                                                ✏️
                                            </a>

                                            <form action="/customer/{{ $d->id }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                                                    🗑
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Belum ada data customer
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>

@endsection


@section('styles')
    <style>
        /* 🔥 FORCE FOTO JADI KOTAK BESAR */
        .foto-fix {
            width: 130px !important;
            height: 130px !important;
            object-fit: cover !important;
            border-radius: 10px !important;
            display: block !important;
            margin: auto !important;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        /* 🔥 ALAMAT GA BOLEH NABRAK */
        .alamat-fix {
            white-space: normal !important;
            word-break: break-word !important;
            line-height: 1.6 !important;
        }

        /* 🔥 WILAYAH */
        .wilayah-fix {
            line-height: 1.6 !important;
        }

        /* 🔥 JARAK ROW */
        table td {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
            vertical-align: middle !important;
        }

        /* 🔥 HEADER */
        table th {
            font-weight: 600;
            font-size: 14px;
        }
    </style>
@endsection