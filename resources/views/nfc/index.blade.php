<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NFC Scanner</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icon --}}
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.4.47/css/materialdesignicons.min.css">

    <style>
        body {
            background: #f4efff;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: sans-serif;
        }

        .nfc-card {
            width: 100%;
            max-width: 600px;
            border: none;
            border-radius: 25px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .top-section {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            padding: 45px 30px;
            text-align: center;
            color: white;
            position: relative;
        }

        .top-section::before {
            content: '';
            position: absolute;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -40px;
        }

        .nfc-icon {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            margin-bottom: 20px;
        }

        .body-section {
            padding: 35px;
        }

        .status-box {
            padding: 18px;
            border-radius: 18px;
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 25px;
        }

        .btn-purple {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            border: none;
            color: white;
            width: 100%;
            padding: 18px;
            border-radius: 18px;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-purple:hover {
            color: white;
            transform: translateY(-2px);
            opacity: 0.95;
        }

        .hasil-card {
            margin-top: 30px;
            background: #f8f8ff;
            border-radius: 22px;
            padding: 30px;
        }

        .label-title {
            color: #9a55ff;
            font-weight: bold;
            margin-bottom: 8px;
            margin-top: 15px;
        }

        .hasil-box {
            background: white;
            border-radius: 14px;
            padding: 15px;
            margin-bottom: 10px;
            word-break: break-word;
            border: 1px solid #eee;
        }

        .scan-time {
            background: #eef7ff;
            color: #0d6efd;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            margin-top: 15px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 14px;
            padding: 14px;
        }

        @media(max-width: 576px) {

            .top-section {
                padding: 35px 20px;
            }

            .body-section {
                padding: 20px;
            }

            .status-box {
                font-size: 16px;
            }

            .btn-purple {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="nfc-card">

        {{-- HEADER --}}
        <div class="top-section">

            <div class="nfc-icon">
                <i class="mdi mdi-nfc text-white" style="font-size:45px;"></i>
            </div>

            <h1 class="fw-bold">
                NFC Scanner
            </h1>

            <p class="mb-0 fs-4">
                Scan KTM untuk identifikasi mahasiswa
            </p>

        </div>

        {{-- BODY --}}
        <div class="body-section">

            {{-- STATUS --}}
            <div id="status" class="status-box bg-light text-dark">

                NFC belum aktif

            </div>

            {{-- BUTTON --}}
            <button onclick="startScan()" class="btn btn-purple">

                <i class="mdi mdi-access-point me-2"></i>
                Aktifkan NFC

            </button>

            {{-- HASIL --}}
            <div id="hasil"></div>

        </div>

    </div>

    <script>

        async function startScan() {

            const status = document.getElementById('status');
            const hasil = document.getElementById('hasil');

            // cek browser support
            if (!('NDEFReader' in window)) {

                status.className =
                    'status-box bg-danger text-white';

                status.innerText =
                    'Browser tidak mendukung Web NFC';

                return;
            }

            try {

                const izin = confirm(
                    'Aktifkan scanner NFC sekarang?'
                );

                if (!izin) {
                    return;
                }

                const ndef = new NDEFReader();

                await ndef.scan();

                status.className =
                    'status-box bg-success text-white';

                status.innerText =
                    'NFC aktif, dekatkan kartu ke belakang HP';

                ndef.addEventListener('reading', async ({
                    serialNumber,
                    message
                }) => {

                    let isi = '';

                    try {

                        for (const record of message.records) {

                            try {

                                isi += new TextDecoder()
                                    .decode(record.data);

                            } catch {

                                isi +=
                                    '[Data tidak dapat dibaca]';
                            }
                        }

                    } catch {

                        isi = 'Tidak ada isi kartu';
                    }

                    console.log(serialNumber);
                    console.log(isi);

                    // cek data ke database
                    const response = await fetch('/cek-nfc', {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            serial_number: serialNumber
                        })
                    });

                    const data = await response.json();

                    // kalau kartu sudah terdaftar
                    if (data && data.serial_number) {

                        // simpan absensi otomatis
                        await fetch('/simpan-absensi', {

                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                serial_number: data.serial_number,
                                nama: data.nama,
                                nim: data.nim,
                                prodi: data.prodi
                            })
                            
                        });

                        hasil.innerHTML = `

                            <div class="hasil-card">

                                <div class="text-center mb-4">

                                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:90px;height:90px;">

                                        <i class="mdi mdi-check text-white"
                                            style="font-size:45px;"></i>

                                    </div>

                                </div>

                                <h2 class="text-success text-center fw-bold mb-4">
                                    Kartu Sudah Terdaftar
                                </h2>

                                <div class="label-title">
                                    Serial Number
                                </div>

                                <div class="hasil-box">
                                    ${data.serial_number}
                                </div>

                                <div class="label-title">
                                    Nama
                                </div>

                                <div class="hasil-box">
                                    ${data.nama}
                                </div>

                                <div class="label-title">
                                    NIM
                                </div>

                                <div class="hasil-box">
                                    ${data.nim}
                                </div>

                                <div class="label-title">
                                    Prodi
                                </div>

                                <div class="hasil-box">
                                    ${data.prodi}
                                </div>

                                <div class="scan-time">
                                    <i class="mdi mdi-clock-outline"></i>
                                    Waktu Scan :
                                    ${new Date().toLocaleString()}
                                </div>

                                <button onclick="location.reload()"
                                    class="btn btn-secondary mt-4 w-100">

                                    Scan Ulang

                                </button>

                            </div>
                        `;

                    }

                    // kalau kartu belum terdaftar
                    else {

                        hasil.innerHTML = `

                            <div class="hasil-card">

                                <h2 class="text-primary fw-bold mb-4">
                                    Kartu Belum Terdaftar
                                </h2>

                                <div class="mb-3">

                                    <label class="form-label">
                                        Serial Number
                                    </label>

                                    <input type="text"
                                        id="serial"
                                        class="form-control"
                                        value="${serialNumber}"
                                        readonly>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">
                                        Nama
                                    </label>

                                    <input type="text"
                                        id="nama"
                                        class="form-control"
                                        placeholder="Masukkan nama">

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">
                                        NIM
                                    </label>

                                    <input type="text"
                                        id="nim"
                                        class="form-control"
                                        placeholder="Masukkan NIM">

                                </div>

                                <div class="mb-4">

                                    <label class="form-label">
                                        Prodi
                                    </label>

                                    <input type="text"
                                        id="prodi"
                                        class="form-control"
                                        placeholder="Masukkan prodi">

                                </div>

                                <button onclick="simpanData()"
                                    class="btn btn-purple">

                                    <i class="mdi mdi-content-save me-2"></i>
                                    Daftarkan Kartu

                                </button>

                            </div>
                        `;
                    }

                });

            } catch (error) {

                console.log(error);

                status.className =
                    'status-box bg-danger text-white';

                status.innerText =
                    'Error : ' + error.message;
            }
        }

        // simpan data kartu baru
        async function simpanData() {

            const serial =
                document.getElementById('serial').value;

            const nama =
                document.getElementById('nama').value;

            const nim =
                document.getElementById('nim').value;

            const prodi =
                document.getElementById('prodi').value;

            if (!nama || !nim || !prodi) {

                alert('Semua data harus diisi');

                return;
            }

            try {

                const response = await fetch('/simpan-nfc', {

                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    body: JSON.stringify({
                        serial_number: serial,
                        nama: nama,
                        nim: nim,
                        prodi: prodi
                    })
                });

                const data = await response.json();

                if (data.success) {

                    alert(
                        'Kartu berhasil didaftarkan'
                    );

                    location.reload();
                }

            } catch (error) {

                console.log(error);

                alert('Gagal menyimpan data');
            }
        }

    </script>

</body>

</html>