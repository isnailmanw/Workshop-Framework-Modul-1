<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Papan Antrian - RS Digital</title>

    <!-- Purple Free -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background: #f5f3ff;
            font-family: "ubuntu", sans-serif;
            overflow-x: hidden;
        }

        .main-wrapper {
            padding: 25px;
        }

        .top-header {
            background: linear-gradient(135deg,
                    #da8cff 0%,
                    #9a55ff 100%);

            border-radius: 24px;
            padding: 24px 30px;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .top-header::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -120px;
            right: -80px;
        }

        .live-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
        }

        .clock {
            font-size: 38px;
            font-weight: 700;
            line-height: 1;
        }

        .date-text {
            color: rgba(255, 255, 255, 0.8);
            margin-top: 6px;
        }

        .current-card {
            border: none;
            border-radius: 28px;
            overflow: hidden;
            background: linear-gradient(135deg,
                    #9a55ff 0%,
                    #6f42c1 100%);

            color: white;
            position: relative;
            min-height: 330px;
            box-shadow: 0 20px 50px rgba(154, 85, 255, 0.18);
        }

        .current-card::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -80px;
            right: -80px;
        }

        .current-card-body {
            padding: 40px;
            position: relative;
            z-index: 2;
        }

        .section-label {
            letter-spacing: 3px;
            text-transform: uppercase;
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 18px;
        }

        .queue-number {
            font-size: 100px;
            font-weight: 700;
            line-height: 1;
        }

        .queue-poli {
            font-size: 28px;
            font-weight: 600;
            margin-top: 12px;
        }

        .queue-status {
            margin-top: 10px;
            opacity: 0.85;
        }

        .speaker-icon {
            font-size: 100px;
            opacity: 0.15;
        }

        .waiting-card {
            border: none;
            border-radius: 28px;
            overflow: hidden;
            margin-top: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .waiting-card .card-body {
            padding: 30px;
        }

        .waiting-item {
            background: #faf8ff;
            border: 1px solid #f0ebff;
            border-radius: 18px;
            padding: 18px 22px;
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .waiting-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(154, 85, 255, 0.08);
        }

        .waiting-number {
            width: 80px;
            height: 80px;
            border-radius: 18px;
            background: linear-gradient(135deg,
                    #da8cff 0%,
                    #9a55ff 100%);

            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: 700;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .waiting-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .waiting-poli {
            color: #9a55ff;
            font-weight: 500;
            margin-top: 5px;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 80px;
            color: #d4c2ff;
        }

        .empty-state h4 {
            margin-top: 20px;
            color: #6c7293;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            color: #8b8b8b;
            font-size: 14px;
        }

        .mini-info-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .mini-info-card .card-body {
            padding: 22px;
        }

        .mini-icon {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            background: rgba(154, 85, 255, 0.12);
            color: #9a55ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
    </style>

</head>

<body>

    <div class="main-wrapper">

        <!-- HEADER -->
        <div class="top-header">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <h2 class="font-weight-bold mb-1">

                        RS Digital

                    </h2>

                    <p class="mb-0">

                        Sistem Antrian Realtime

                    </p>

                </div>

                <div class="text-md-right mt-3 mt-md-0">

                    <div class="clock" id="clock">

                        00:00:00

                    </div>

                    <div class="date-text" id="dateText">

                        -

                    </div>

                    <div class="live-badge mt-3 d-inline-flex align-items-center">

                        <span style="
                            width:10px;
                            height:10px;
                            background:white;
                            border-radius:50%;
                            margin-right:8px;
                            display:inline-block;
                        "></span>

                        LIVE

                    </div>

                </div>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="row">

            <!-- CURRENT -->
            <div class="col-lg-8 mb-4">

                <div class="card current-card">

                    <div class="current-card-body h-100">

                        <div class="d-flex justify-content-between align-items-center h-100">

                            <div>

                                <div class="section-label">

                                    Sedang Dipanggil

                                </div>

                                <div class="queue-number" id="papan-number">

                                    @if($current)

                                        {{ str_pad($current->nomor_antrian, 3, '0', STR_PAD_LEFT) }}

                                    @else

                                        ---

                                    @endif

                                </div>

                                <div class="queue-poli" id="papan-poli">

                                    {{ $current->poli->nama_poli ?? 'Belum Ada Antrian' }}

                                </div>

                                <div class="queue-status">

                                    Silahkan menuju loket pelayanan

                                </div>

                            </div>

                            <div class="d-none d-md-block">

                                <i class="mdi mdi-volume-high speaker-icon"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SIDE -->
            <div class="col-lg-4 mb-4">

                <div class="card mini-info-card mb-4">

                    <div class="card-body d-flex align-items-center">

                        <div class="mini-icon mr-3">

                            <i class="mdi mdi-account-group"></i>

                        </div>

                        <div>

                            <h3 class="font-weight-bold mb-0" id="waiting-count">

                                {{ $waitingList->count() }}

                            </h3>

                            <p class="mb-0 text-muted">

                                Antrian Menunggu

                            </p>

                        </div>

                    </div>

                </div>

                <div class="card mini-info-card">

                    <div class="card-body d-flex align-items-center">

                        <div class="mini-icon mr-3">

                            <i class="mdi mdi-lightning-bolt"></i>

                        </div>

                        <div>

                            <h5 class="font-weight-bold mb-1">

                                Realtime SSE

                            </h5>

                            <p class="mb-0 text-muted" id="sseStatus">

                                Menghubungkan...

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- WAITING -->
        <div class="card waiting-card">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="font-weight-bold mb-1">

                            Daftar Antrian

                        </h4>

                        <p class="text-muted mb-0">

                            Antrian yang sedang menunggu

                        </p>

                    </div>

                </div>

                <div id="waiting-list">

                    @forelse($waitingList as $item)

                        <div class="waiting-item">

                            <div class="d-flex align-items-center">

                                <div class="waiting-number">

                                    {{ str_pad($item->nomor_antrian, 3, '0', STR_PAD_LEFT) }}

                                </div>

                                <div>

                                    <div class="waiting-name">

                                        {{ $item->nama_pengunjung }}

                                    </div>

                                    <div class="waiting-poli">

                                        {{ $item->poli->nama_poli ?? '-' }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="empty-state">

                            <i class="mdi mdi-check-circle-outline"></i>

                            <h4>

                                Tidak Ada Antrian Menunggu

                            </h4>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="footer-text">

            RS Digital — Sistem Antrian Realtime © 2026

        </div>

    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        // CLOCK
        function updateClock() {

            const now = new Date();

            document.getElementById('clock').innerHTML =
                now.toLocaleTimeString('id-ID');

            document.getElementById('dateText').innerHTML =
                now.toLocaleDateString('id-ID', {

                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'

                });

        }

        setInterval(updateClock, 1000);

        updateClock();

        // SSE
        const source = new EventSource('/stream-antrian?nocache=' + Math.random());

        source.onopen = function () {

            $('#sseStatus').html('Realtime aktif');

        };

        source.onerror = function () {

            $('#sseStatus').html('Koneksi terputus');

        };

        source.addEventListener('update', function (event) {

            const data = JSON.parse(event.data);

            // current
            if (data.current) {

                $('#papan-number').html(
                    String(data.current.nomor_antrian)
                        .padStart(3, '0')
                );

                $('#papan-poli').html(
                    data.current.poli
                        ? data.current.poli.nama_poli
                        : '-'
                );

            } else {

                $('#papan-number').html('---');

                $('#papan-poli').html('Belum Ada Antrian');

            }

            // waiting count
            $('#waiting-count').html(data.waiting);

            // waiting list
            let html = '';

            const waiting =
                data.queues.filter(q => q.status === 'waiting');

            if (waiting.length === 0) {

                html = `
                    <div class="empty-state">

                        <i class="mdi mdi-check-circle-outline"></i>

                        <h4>
                            Tidak Ada Antrian Menunggu
                        </h4>

                    </div>
                `;

            } else {

                waiting.forEach(function (item) {

                    html += `
                        <div class="waiting-item">

                            <div class="d-flex align-items-center">

                                <div class="waiting-number">

                                    ${String(item.nomor_antrian).padStart(3, '0')}

                                </div>

                                <div>

                                    <div class="waiting-name">

                                        ${item.nama_pengunjung}

                                    </div>

                                    <div class="waiting-poli">

                                        ${item.poli ? item.poli.nama_poli : '-'}

                                    </div>

                                </div>

                            </div>

                        </div>
                    `;

                });

            }

            $('#waiting-list').html(html);

        });

    </script>

</body>

</html>