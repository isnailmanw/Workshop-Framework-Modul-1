@extends('layouts.master')

@section('styles')

    <style>
        #reader {
            border: none !important;
        }

        #reader video {
            border-radius: 20px;
        }

        #reader__scan_region {
            background: #f8f6ff;
            border-radius: 20px;
            overflow: hidden;
        }

        #reader__dashboard {
            border-top: none !important;
            padding-top: 15px;
        }

        #reader__dashboard_section_csr button {
            background: linear-gradient(to right, #8b5cf6, #7c3aed);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
        }

        #reader__dashboard_section_swaplink {
            display: none !important;
        }

        #reader select {
            border-radius: 10px;
            padding: 8px;
            border: 1px solid #ddd;
        }
    </style>

@endsection

@section('content')

    <div class="content-wrapper">

        <div class="row justify-content-center">

            <div class="col-lg-7 grid-margin stretch-card">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body text-center">

                        <!-- HEADER -->
                        <div class="mb-4">

                            <h2 class="font-weight-bold text-dark mb-2">

                                Scan QR Kunjungan

                            </h2>

                            <p class="text-muted mb-0">

                                Scan QR toko untuk validasi kunjungan sales

                            </p>

                        </div>


                        <!-- SCANNER -->
                        <div class="d-flex justify-content-center">

                            <div id="reader" style="width:100%; max-width:450px;">

                            </div>

                        </div>



                        <!-- AUDIO -->
                        <audio id="beep"
                               src="{{ asset('beep.mp3') }}">

                        </audio>



                        <!-- HASIL SCAN -->
                        <div id="hasil-scan"
                             class="mt-3">

                            <div class="alert alert-light border text-muted">

                                Arahkan kamera ke QR Code toko

                            </div>

                        </div>



                        <!-- HASIL VALIDASI -->
                        <div id="hasil-validasi"
                             class="mt-4">

                        </div>



                        <!-- BUTTON -->
                        <div class="mt-4">

                            <button class="btn btn-gradient-primary btn-fw"
                                    onclick="scanLagi()">

                                <i class="mdi mdi-qrcode-scan"></i>

                                Scan Lagi

                            </button>

                            <a href="/kunjungan-toko"
                               class="btn btn-light btn-fw">

                                Kembali

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



@section('scripts')

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>

        let scanner;

        let isScanning = true;



        // 🔊 SOUND
        function playBeep()
        {
            const beep = document.getElementById("beep");

            beep.pause();

            beep.currentTime = 0;

            beep.volume = 1.0;

            beep.play();
        }



        // INIT SCANNER
        function initScanner()
        {
            scanner = new Html5QrcodeScanner(

                "reader",

                {
                    fps: 10,
                    qrbox: 250
                }

            );

            scanner.render(onScanSuccess);
        }



        // HAVERSINE
        function hitungJarak(lat1, lng1, lat2, lng2)
        {
            const R = 6371000;

            const dLat =
                (lat2 - lat1) * Math.PI / 180;

            const dLng =
                (lng2 - lng1) * Math.PI / 180;

            const a =

                Math.sin(dLat / 2) *
                Math.sin(dLat / 2) +

                Math.cos(lat1 * Math.PI / 180) *
                Math.cos(lat2 * Math.PI / 180) *

                Math.sin(dLng / 2) *
                Math.sin(dLng / 2);

            const c =
                2 * Math.atan2(
                    Math.sqrt(a),
                    Math.sqrt(1 - a)
                );

            return R * c;
        }



        // SUCCESS SCAN
        function onScanSuccess(decodedText)
        {
            if (!isScanning) return;

            isScanning = false;

            playBeep();



            document.getElementById('hasil-scan').innerHTML =

            `
                <div class="alert alert-info">

                    <i class="mdi mdi-loading mdi-spin"></i>

                    Memuat data toko...

                </div>
            `;



            fetch('/api/toko/' + decodedText)

            .then(response => response.json())

            .then(data =>
            {
                if (!data)
                {
                    document.getElementById('hasil-scan').innerHTML =

                    `
                        <div class="alert alert-danger">

                            QR / Barcode toko tidak ditemukan

                        </div>
                    `;

                    return;
                }



                // TAMPIL DATA TOKO
                document.getElementById('hasil-scan').innerHTML =

                `
                    <div class="card border-0 shadow-sm mt-3">

                        <div class="card-body text-left">

                            <div class="d-flex align-items-center mb-3">

                                <div class="bg-success rounded-circle mr-3"
                                     style="width:12px;height:12px;">

                                </div>

                                <h5 class="mb-0 font-weight-bold text-success">

                                    Toko Ditemukan

                                </h5>

                            </div>

                            <table class="table table-borderless">

                                <tr>
                                    <th width="35%">
                                        Barcode
                                    </th>

                                    <td>
                                        ${data.barcode}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Nama Toko
                                    </th>

                                    <td>
                                        ${data.nama_toko}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Latitude
                                    </th>

                                    <td>
                                        ${data.latitude}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Longitude
                                    </th>

                                    <td>
                                        ${data.longitude}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Accuracy
                                    </th>

                                    <td>

                                        <span class="badge badge-success px-3 py-2">

                                            ${parseFloat(data.accuracy).toFixed(2)} m

                                        </span>

                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>
                `;



                // AMBIL LOKASI SALES
                navigator.geolocation.getCurrentPosition(

                    function(position)
                    {
                        const salesLat =
                            position.coords.latitude;

                        const salesLng =
                            position.coords.longitude;

                        const salesAccuracy =
                            position.coords.accuracy;



                        // HITUNG JARAK
                        const jarak = hitungJarak(

                            parseFloat(data.latitude),
                            parseFloat(data.longitude),

                            salesLat,
                            salesLng
                        );



                        // THRESHOLD
                        const THRESHOLD = 100;



                        // THRESHOLD EFEKTIF
                        const thresholdEfektif =

                            THRESHOLD +

                            parseFloat(data.accuracy) +

                            parseFloat(salesAccuracy);



                        // VALIDASI
                        let status = '';

                        let warna = '';



                        if (jarak <= thresholdEfektif)
                        {
                            status = 'VALID';

                            warna = 'success';
                        }
                        else
                        {
                            status = 'DI LUAR AREA';

                            warna = 'danger';
                        }



                        // TAMPIL VALIDASI
                        document.getElementById('hasil-validasi').innerHTML =

                        `
                            <div class="alert alert-${warna}">

                                <h5 class="mb-3">

                                    Hasil Validasi Kunjungan

                                </h5>

                                <p class="mb-1">

                                    Jarak Aktual:
                                    <strong>
                                        ${jarak.toFixed(2)} meter
                                    </strong>

                                </p>

                                <p class="mb-1">

                                    Accuracy Toko:
                                    <strong>
                                        ${parseFloat(data.accuracy).toFixed(2)} meter
                                    </strong>

                                </p>

                                <p class="mb-1">

                                    Accuracy Sales:
                                    <strong>
                                        ${salesAccuracy.toFixed(2)} meter
                                    </strong>

                                </p>

                                <p class="mb-1">

                                    Threshold Dasar:
                                    <strong>
                                        ${THRESHOLD} meter
                                    </strong>

                                </p>

                                <p class="mb-3">

                                    Threshold Efektif:
                                    <strong>
                                        ${thresholdEfektif.toFixed(2)} meter
                                    </strong>

                                </p>

                                <h5 class="mb-0">

                                    Status:
                                    <strong>
                                        ${status}
                                    </strong>

                                </h5>

                            </div>
                        `;
                    }

                );



                // PAUSE SCANNER
                scanner.pause(true);

            })

            .catch(() =>
            {
                document.getElementById('hasil-scan').innerHTML =

                `
                    <div class="alert alert-danger">

                        Terjadi error server

                    </div>
                `;
            });
        }



        // 🔄 SCAN LAGI
        function scanLagi()
        {
            isScanning = true;

            document.getElementById('hasil-scan').innerHTML =

            `
                <div class="alert alert-light border text-muted">

                    Arahkan kamera ke QR Code toko

                </div>
            `;

            document.getElementById('hasil-validasi').innerHTML = '';

            scanner.resume();
        }



        window.onload = initScanner;

    </script>

@endsection