@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="row justify-content-center">

            <div class="col-lg-6 grid-margin stretch-card">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body text-center">

                        <h2 class="font-weight-bold mb-3">

                            QR Code Toko

                        </h2>

                        <p class="text-muted mb-4">

                            {{ $toko->nama_toko }}

                        </p>

                        <div class="mb-4">

                            {!! QrCode::size(250)->generate($toko->barcode) !!}

                        </div>

                        <h4 class="text-dark">

                            {{ $toko->barcode }}

                        </h4>

                        <a href="/kunjungan-toko" class="btn btn-light mt-4">

                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection