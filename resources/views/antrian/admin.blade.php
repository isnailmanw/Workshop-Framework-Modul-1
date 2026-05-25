<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Antrian</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            background: #f5f3ff;
            font-family: "ubuntu", sans-serif;
        }

        .page-header-custom {
            background: linear-gradient(135deg, #da8cff 0%, #9a55ff 100%);
            border-radius: 24px;
            padding: 35px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .page-header-custom::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -100px;
            right: -80px;
        }

        .action-btn {
            height: 52px;
            border-radius: 14px;
            font-weight: 600;
        }

        .stat-card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            color: white;
            position: relative;
        }

        .stat-card .card-body {
            padding: 28px;
        }

        .stat-card i {
            font-size: 34px;
            opacity: 0.9;
        }

        .gradient-purple {
            background: linear-gradient(135deg, #9a55ff 0%, #da8cff 100%);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
        }

        .gradient-pink {
            background: linear-gradient(135deg, #ff758c 0%, #ff7eb3 100%);
        }

        .gradient-cyan {
            background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
        }

        .current-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .queue-number {
            font-size: 72px;
            font-weight: 700;
            color: #9a55ff;
            line-height: 1;
        }

        .table-card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #6c7293;
        }

        .badge-custom {
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-table {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .sse-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.15);
            margin-top: 8px;
        }

        .sse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            animation: pulse 1.5s infinite;
        }

        .sse-dot.disconnected {
            background: #f87171;
            animation: none;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }
    </style>
</head>

<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper">
                <div class="container">

                    <!-- HEADER -->
                    <div class="page-header-custom mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h2 class="font-weight-bold mb-2">Dashboard Antrian</h2>
                                <p class="mb-0">Sistem antrian realtime RS Digital</p>

                                <div class="sse-indicator">
                                    <div class="sse-dot disconnected" id="sseDot"></div>
                                    <span id="sseStatus">Menghubungkan...</span>
                                </div>
                            </div>

                            <div class="mt-3 mt-md-0">
                                <a href="/papan-antrian" class="btn btn-light action-btn">
                                    <i class="mdi mdi-monitor-dashboard mr-1"></i>
                                    Buka Papan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- CURRENT -->
                    <div class="row">

                        <div class="col-lg-8 mb-4">
                            <div class="card current-card shadow-sm">
                                <div class="card-body p-5">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <p class="text-muted mb-2">
                                                Sedang Dipanggil
                                            </p>

                                            <div class="queue-number" id="currentNumber">

                                                @if($current)
                                                    {{ str_pad($current->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                                                @else
                                                    ---
                                                @endif

                                            </div>

                                            <h5 class="mt-3 font-weight-bold" id="currentPoli">

                                                {{ $current->poli->nama_poli ?? 'Belum ada antrian' }}

                                            </h5>

                                        </div>

                                        <div>
                                            <i class="mdi mdi-bullhorn text-primary" style="font-size: 90px;"></i>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ACTION -->
                        <div class="col-lg-4 mb-4">

                            <div class="card border-0 shadow-sm" style="border-radius:24px;">

                                <div class="card-body">

                                    <button id="btnPanggil" class="btn btn-gradient-primary btn-block action-btn mb-3">

                                        <i class="mdi mdi-volume-high mr-1"></i>

                                        Panggil Berikutnya

                                    </button>

                                    <a href="/papan-antrian" class="btn btn-light btn-block action-btn">

                                        <i class="mdi mdi-monitor mr-1"></i>

                                        Lihat Papan

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- STAT -->
                    <div class="row">

                        <div class="col-md-3 mb-4">
                            <div class="card stat-card gradient-purple">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>
                                            <h2 class="font-weight-bold">
                                                <span id="waitingCount">
                                                    {{ $waiting }}
                                                </span>
                                            </h2>

                                            <p class="mb-0">Menunggu</p>
                                        </div>

                                        <i class="mdi mdi-timer-sand"></i>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stat-card gradient-blue">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>
                                            <h2 class="font-weight-bold">
                                                <span id="calledCount">
                                                    {{ $called }}
                                                </span>
                                            </h2>

                                            <p class="mb-0">Dipanggil</p>
                                        </div>

                                        <i class="mdi mdi-volume-high"></i>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stat-card gradient-pink">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>
                                            <h2 class="font-weight-bold">
                                                <span id="doneCount">
                                                    {{ $done }}
                                                </span>
                                            </h2>

                                            <p class="mb-0">Selesai</p>
                                        </div>

                                        <i class="mdi mdi-check-circle"></i>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stat-card gradient-cyan">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between">

                                        <div>
                                            <h2 class="font-weight-bold">
                                                <span id="totalCount">
                                                    {{ $total }}
                                                </span>
                                            </h2>

                                            <p class="mb-0">Total</p>
                                        </div>

                                        <i class="mdi mdi-chart-line"></i>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TABLE -->
                    <div class="card table-card shadow-sm">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>

                                    <h4 class="font-weight-bold mb-1">
                                        Daftar Antrian
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Data realtime hari ini
                                    </p>

                                </div>

                            </div>

                            <div class="table-responsive">

                                <table class="table">

                                    <thead>

                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama</th>
                                            <th>Poli</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>

                                    </thead>

                                    <tbody id="antrianTable">

                                        @forelse($antrian as $item)

                                            <tr>

                                                <td>
                                                    <strong>
                                                        {{ str_pad($item->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                                                    </strong>
                                                </td>

                                                <td>
                                                    {{ $item->nama_pengunjung }}
                                                </td>

                                                <td>
                                                    {{ $item->poli->nama_poli ?? '-' }}
                                                </td>

                                                <td>

                                                    @if($item->status == 'waiting')

                                                        <span class="badge badge-warning badge-custom">
                                                            Menunggu
                                                        </span>

                                                    @elseif($item->status == 'called')

                                                        <span class="badge badge-info badge-custom">
                                                            Dipanggil
                                                        </span>

                                                    @else

                                                        <span class="badge badge-success badge-custom">
                                                            Selesai
                                                        </span>

                                                    @endif

                                                </td>

                                                <td>

                                                    <button class="btn btn-success btn-table"
                                                        onclick="selesaiAntrian({{ $item->id }})">

                                                        <i class="mdi mdi-check"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="5" class="text-center text-muted">

                                                    Belum ada data antrian

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
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>

    <script src="{{ asset('assets/js/misc.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        let lastCalled = null;

        let speechUnlocked = false;
        window.speechSynthesis.getVoices();

        speechSynthesis.onvoiceschanged = () => {
            speechSynthesis.getVoices();
        };

        window.speechSynthesis.getVoices();

        // unlock suara
        document.addEventListener('click', function () {

            speechUnlocked = true;

        }, { once: true });

        function bunyikanSuara(nomor, poli) {

            window.speechSynthesis.cancel();

            const speech = new SpeechSynthesisUtterance(
                `Nomor antrian ${nomor}, silahkan menuju ${poli}`
            );

            speech.lang = 'id-ID';

            speech.volume = 1;

            speech.rate = 0.9;

            speech.pitch = 1;

            window.speechSynthesis.speak(speech);

        }

        // panggil berikutnya
        $('#btnPanggil').click(function () {

            const btn = $(this);

            btn.prop('disabled', true);

            btn.html(`
                <span class="spinner-border spinner-border-sm mr-1"></span>
                Memanggil...
            `);

            $.post('/panggil-antrian', {

                _token: '{{ csrf_token() }}'

            })

                .done(function (res) {

                    if (!res.success) {

                        Swal.fire({

                            icon: 'warning',

                            title: 'Info',

                            text: 'Tidak ada antrian menunggu'

                        });

                        return;
                    }

                    // tunggu sebentar biar data DB sudah update
                    setTimeout(() => {

                        const nomor =
                            $('#currentNumber').text().trim();

                        const poli =
                            $('#currentPoli').text().trim();

                        bunyikanSuara(nomor, poli);

                    }, 500);

                })

                .fail(function () {

                    Swal.fire({

                        icon: 'error',

                        title: 'Gagal',

                        text: 'Terjadi kesalahan'

                    });

                })

                .always(function () {

                    btn.prop('disabled', false);

                    btn.html(`
                        <i class="mdi mdi-volume-high mr-1"></i>
                        Panggil Berikutnya
                    `);

                });

        });

        // selesai
        function selesaiAntrian(id) {

            $.post(`/selesai-antrian/${id}`, {

                _token: '{{ csrf_token() }}'

            });

        }

        // SSE
        const source = new EventSource('/stream-antrian?nocache=' + Math.random());

        source.onopen = function () {

            document.getElementById('sseStatus').innerHTML = 'Realtime aktif';

            document.getElementById('sseDot').classList.remove('disconnected');

        };

        source.onerror = function () {

            document.getElementById('sseStatus').innerHTML = 'Koneksi terputus';

            document.getElementById('sseDot').classList.add('disconnected');

        };

        source.addEventListener('update', function (event) {

            const data = JSON.parse(event.data);

            // current
            if (data.current) {

                const nomor = String(
                    data.current.nomor_antrian
                ).padStart(3, '0');

                const poli = data.current.poli
                    ? data.current.poli.nama_poli
                    : '-';

                $('#currentNumber').html(nomor);

                $('#currentPoli').html(poli);



            } else {

                $('#currentNumber').html('---');

                $('#currentPoli').html('Belum ada antrian');

            }

            // statistik
            $('#waitingCount').html(data.waiting);

            $('#calledCount').html(data.called);

            $('#doneCount').html(data.done);

            $('#totalCount').html(data.total);

            // table
            let rows = '';

            if (data.queues.length > 0) {

                data.queues.forEach(function (item) {

                    let badge = '';

                    if (item.status === 'waiting') {

                        badge = `
                            <span class="badge badge-warning badge-custom">
                                Menunggu
                            </span>
                        `;

                    } else if (item.status === 'called') {

                        badge = `
                            <span class="badge badge-info badge-custom">
                                Dipanggil
                            </span>
                        `;

                    } else {

                        badge = `
                            <span class="badge badge-success badge-custom">
                                Selesai
                            </span>
                        `;

                    }

                    rows += `
                        <tr>

                            <td>
                                <strong>
                                    ${String(item.nomor_antrian).padStart(3, '0')}
                                </strong>
                            </td>

                            <td>
                                ${item.nama_pengunjung}
                            </td>

                            <td>
                                ${item.poli ? item.poli.nama_poli : '-'}
                            </td>

                            <td>
                                ${badge}
                            </td>

                            <td>

                                <button class="btn btn-success btn-table"
                                    onclick="selesaiAntrian(${item.id})">

                                    <i class="mdi mdi-check"></i>

                                </button>

                            </td>

                        </tr>
                    `;

                });

            } else {

                rows = `
                    <tr>

                        <td colspan="5"
                            class="text-center text-muted">

                            Belum ada data antrian

                        </td>

                    </tr>
                `;

            }

            $('#antrianTable').html(rows);

        });

    </script>

</body>

</html>