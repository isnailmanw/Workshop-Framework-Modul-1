@extends('layouts.master')

@section('content')

    <title>Scanner Barcode</title>

    <!-- Library Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- Style (disesuaikan nuansa purple project kamu) -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f3ff;
            padding: 20px;
        }

        .container {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            color: #6c63ff;
        }

        #reader {
            margin: auto;
        }

        #result {
            margin-top: 15px;
            text-align: left;
            padding: 12px;
            background: #f6f6ff;
            border-radius: 10px;
            font-size: 14px;
        }

        .btn {
            margin-top: 15px;
            padding: 10px 15px;
            background: #6c63ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn:hover {
            background: #574fd6;
        }
    </style>


    <div class="container">
        <h2>Scan Barcode Barang</h2>

        <!-- Scanner -->
        <div id="reader" style="width:300px;"></div>

        <!-- Audio -->
        <audio id="beep" src="{{ asset('beep.mp3') }}"></audio>

        <!-- Result -->
        <div id="result">Silakan scan barcode...</div>

        <!-- Tombol Scan Lagi -->
        <button id="scanBtn" class="btn" onclick="scanAgain()">
            Scan Lagi
        </button>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        const beep = document.getElementById("beep");

        beep.volume = 1.0; // maksimal (0.0 - 1.0)
        beep.play();

        let scanner;
        let isLocked = false;

        function initScanner() {
            scanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 15,
                    qrbox: { width: 250, height: 150 }, // lebih cocok buat barcode (horizontal)
                    aspectRatio: 1.5,
                    rememberLastUsedCamera: true
                }
            );

            scanner.render(onScanSuccess);
        }

        function onScanSuccess(decodedText) {
            if (isLocked) return;
            isLocked = true;

            beep.play();

            document.getElementById("result").innerHTML = "Loading...";

            fetch("/get-barang/" + decodedText)
                .then(res => res.json())
                .then(data => {
                    if (!data || !data.kode) {
                        document.getElementById("result").innerHTML =
                            `<p style="color:red;">Barang tidak ditemukan</p>`;
                    } else {
                        document.getElementById("result").innerHTML = `
                                                    <h3 style="color:#6c63ff;">Data Barang</h3>
                                                    <b>Kode:</b> ${data.kode}<br>
                                                    <b>Nama:</b> ${data.nama}<br>
                                                    <b>Harga:</b> Rp ${parseInt(data.harga).toLocaleString('id-ID')}
                                                `;
                    }

                    // ⏸ pause scanner TANPA error
                    scanner.pause(true);

                    // tampilkan tombol scan lagi
                    document.getElementById("scanBtn").style.display = "block";
                });
        }

        function scanAgain() {
            document.getElementById("result").innerHTML = "Arahkan ke barcode...";
            document.getElementById("scanBtn").style.display = "none";

            isLocked = false;

            // ▶️ resume scanner
            scanner.resume();
        }

        window.onload = initScanner;
    </script>

@endsection