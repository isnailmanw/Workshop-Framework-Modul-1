<!DOCTYPE html>
<html>

<head>
    <title>Scan QR Pesanan</title>

    <!-- Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: Arial;
            background: #f4f3ff;
            padding: 20px;
        }

        .box {
            max-width: 420px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.15);
        }

        h3 {
            color: #5b21b6;
            margin-bottom: 15px;
        }

        #reader {
            border-radius: 15px;
            overflow: hidden;
            margin: auto;
        }

        #result {
            margin-top: 15px;
            text-align: left;
            background: #f6f6ff;
            padding: 15px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.6;
        }

        .btn {
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        .btn-primary {
            background: #6c63ff;
            color: white;
        }

        .btn-primary:hover {
            background: #5848e5;
        }

        .btn-secondary {
            background: #e5e7eb;
        }

        .status {
            margin-top: 8px;
            font-weight: bold;
        }

        .status.lunas {
            color: green;
        }

        .status.belum {
            color: red;
        }
    </style>
</head>

<body>

    <div class="box">
        <h3>📷 Scan QR Customer</h3>

        <div id="reader" style="width:300px;"></div>

        <!-- 🔊 BEEP SUPER KENCANG -->
        <audio id="beep" src="{{ asset('beep.mp3') }}"></audio>

        <div id="result">
            Arahkan kamera ke QR Code...
        </div>

        <button class="btn btn-primary" onclick="scanAgain()" id="btnScan">
            🔁 Scan Lagi
        </button>

        <button class="btn btn-secondary" onclick="window.location.href='/vendor'">
            ⬅ Kembali ke Dashboard
        </button>
    </div>

    <script>
        let scanner;
        let isScanning = true;

        function playBeep() {
            const beep = document.getElementById("beep");

            beep.pause();
            beep.currentTime = 0;
            beep.volume = 1.0; // 🔥 MAX VOLUME

            // 🔥 ulang 2x biar makin keras
            beep.play();
            setTimeout(() => beep.play(), 150);
        }

        function initScanner() {
            scanner = new Html5QrcodeScanner(
                "reader",
                { fps: 10, qrbox: 250 }
            );

            scanner.render(onScanSuccess);
        }

        function onScanSuccess(decodedText) {

            if (!isScanning) return;
            isScanning = false;

            playBeep();

            document.getElementById("result").innerHTML = "Loading data...";

            let id = decodedText.split('/').pop();

            fetch("/get-order/" + id)
                .then(res => res.json())
                .then(data => {

                    if (!data || !data.details) {
                        document.getElementById("result").innerHTML =
                            `<p style="color:red;">❌ Pesanan tidak ditemukan</p>`;
                        return;
                    }

                    let html = `<h4>🧾 Detail Pesanan</h4>`;

                    data.details.forEach(d => {
                        html += `
                            • ${d.menu.nama_menu} - ${d.qty}x <br>
                        `;
                    });

                    html += `<hr>`;

                    html += `
                        <b>Total:</b> Rp ${parseInt(data.total).toLocaleString('id-ID')} <br>
                    `;

                    let status = data.status ?? 'LUNAS';

                    html += `
                        <div class="status ${status == 'LUNAS' ? 'lunas' : 'belum'}">
                            Status: ${status}
                        </div>
                    `;

                    document.getElementById("result").innerHTML = html;

                    // ⏸ STOP scanner
                    scanner.pause(true);
                })
                .catch(() => {
                    document.getElementById("result").innerHTML =
                        `<p style="color:red;">❌ Terjadi error server</p>`;
                });
        }

        function scanAgain() {
            isScanning = true;
            document.getElementById("result").innerHTML = "Arahkan kamera ke QR Code...";
            scanner.resume();
        }

        window.onload = initScanner;
    </script>

</body>

</html>