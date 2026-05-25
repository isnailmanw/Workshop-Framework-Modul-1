<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RS Digital - Ambil Antrian</title>

    <!-- PURPLE FREE -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            background: #f5f3ff;
            min-height: 100vh;
            font-family: "ubuntu", sans-serif;
            overflow-x: hidden;
        }

        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            position: relative;
        }

        .blur-bg {
            position: absolute;
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: rgba(182, 109, 255, 0.15);
            top: -150px;
            right: -120px;
            filter: blur(30px);
        }

        .blur-bg-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(79, 172, 254, 0.12);
            bottom: -100px;
            left: -100px;
            filter: blur(30px);
        }

        .queue-card {
            width: 100%;
            max-width: 950px;
            border: none;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 2;
        }

        .left-side {
            background: linear-gradient(135deg,
                    #da8cff 0%,
                    #9a55ff 100%);
            padding: 50px;
            color: white;
            position: relative;
        }

        .left-side::before {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -80px;
            right: -80px;
        }

        .left-side::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            bottom: -50px;
            left: -50px;
        }

        .queue-badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 18px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .logo-box {
            width: 78px;
            height: 78px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-box i {
            font-size: 34px;
        }

        .left-title {
            font-size: 58px;
            font-weight: 700;
            line-height: 1.1;
        }

        .mini-card {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 18px;
            backdrop-filter: blur(10px);
        }

        .right-side {
            background: white;
            padding: 50px;
            display: flex;
            align-items: center;
        }

        .form-control {
            height: 54px;
            border-radius: 14px;
            border: 1px solid #ececec;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #9a55ff;
            box-shadow: 0 0 0 0.2rem rgba(154, 85, 255, 0.15);
        }

        .btn-antrian {
            height: 54px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 12px 25px rgba(154, 85, 255, 0.18);
        }

        .btn-board {
            height: 50px;
            border-radius: 14px;
            font-weight: 500;
        }

        .login-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            z-index: 10;
            border-radius: 14px;
            padding: 10px 22px;
            background: white;
            color: #9a55ff;
            font-weight: 600;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .login-btn:hover {
            text-decoration: none;
            transform: translateY(-2px);
            color: #9a55ff;
        }

        /* SELECT2 */

        .select2-container--default .select2-selection--single {
            height: 54px;
            border-radius: 14px;
            border: 1px solid #ececec;
            display: flex;
            align-items: center;
            padding-left: 8px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            line-height: 54px;
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 54px;
        }

        @media(max-width:991px) {

            .left-title {
                font-size: 48px;
            }

            .right-side {
                padding: 35px;
            }

        }
    </style>

</head>

<body>

    <div class="blur-bg"></div>
    <div class="blur-bg-2"></div>

    <!-- LOGIN -->
    <a href="/login" class="login-btn">

        <i class="mdi mdi-account-circle-outline mr-1"></i>

        Login

    </a>

    <div class="main-wrapper">

        <div class="card queue-card">

            <div class="row no-gutters">

                <!-- LEFT -->
                <div class="col-lg-6 left-side d-flex flex-column justify-content-center">

                    <div class="queue-badge">

                        <i class="mdi mdi-lightning-bolt-outline mr-2"></i>

                        Realtime Queue

                    </div>

                    <div class="logo-box">

                        <i class="mdi mdi-hospital-building"></i>

                    </div>

                    <h1 class="left-title">

                        Ambil
                        <br>
                        Nomor
                        <br>
                        Antrian

                    </h1>

                    <div class="row mt-5">

                        <div class="col-6">

                            <div class="mini-card text-center">

                                <h2 class="font-weight-bold mb-1">
                                    30+
                                </h2>

                                <p class="mb-0">
                                    Poli
                                </p>

                            </div>

                        </div>

                        <div class="col-6">

                            <div class="mini-card text-center">

                                <h2 class="font-weight-bold mb-1">
                                    Live
                                </h2>

                                <p class="mb-0">
                                    Update
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-6 right-side">

                    <div class="w-100">

                        <div class="mb-5">

                            <h2 class="font-weight-bold text-dark">
                                Form Antrian
                            </h2>

                            <p class="text-muted mb-0 mt-2">
                                Silahkan isi data pengunjung
                            </p>

                        </div>

                        <!-- FORM -->
                        <form action="{{ route('guest.store') }}" method="POST" id="formAntrian">

                            @csrf

                            <!-- NAMA -->
                            <div class="form-group">

                                <label class="font-weight-semibold text-dark">

                                    Nama Lengkap

                                </label>

                                <input type="text" name="nama_pengunjung" class="form-control"
                                    placeholder="Masukkan nama lengkap" required>

                            </div>

                            <!-- POLI -->
                            <div class="form-group mt-4">

                                <label class="font-weight-semibold text-dark">

                                    Poli / Layanan

                                </label>

                                <select name="poli_id" id="poliSelect" class="form-control" required>

                                    <option value="">
                                        -- Pilih Poli --
                                    </option>

                                    @foreach($poli as $item)

                                        <option value="{{ $item->id }}">

                                            {{ $item->nama_poli }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                            <!-- BUTTON -->
                            <button type="submit" id="btnAmbil"
                                class="btn btn-gradient-primary btn-block btn-antrian mt-5">

                                <span id="btnText">

                                    <i class="mdi mdi-ticket-confirmation mr-2"></i>

                                    Ambil Nomor Antrian

                                </span>

                                <span id="btnLoading" class="d-none">

                                    <span class="spinner-border spinner-border-sm mr-2"></span>

                                    Loading...

                                </span>

                            </button>

                            <!-- PAPAN -->
                            <a href="/papan-antrian" class="btn btn-light btn-block btn-board mt-3">

                                <i class="mdi mdi-monitor-dashboard mr-1"></i>

                                Lihat Papan Antrian

                            </a>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        $(document).ready(function () {

            // SELECT2
            $('#poliSelect').select2({

                placeholder: "Cari poli...",

                width: '100%'

            });

            // SUBMIT
            $('#formAntrian').submit(function (e) {

                e.preventDefault();

                // loading
                $('#btnText').addClass('d-none');

                $('#btnLoading').removeClass('d-none');

                $('#btnAmbil').prop('disabled', true);

                $.ajax({

                    url: "/guest-store",

                    type: "POST",

                    data: $(this).serialize(),

                    success: function (response) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Berhasil',

                            text: 'Nomor antrian berhasil diambil',

                            confirmButtonColor: '#9a55ff'

                        });

                        // reset form
                        $('#formAntrian')[0].reset();

                        // reset select2
                        $('#poliSelect').val(null).trigger('change');

                    },

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({

                            icon: 'error',

                            title: 'Gagal',

                            text: 'Terjadi kesalahan',

                            confirmButtonColor: '#9a55ff'

                        });

                    },

                    complete: function () {

                        $('#btnText').removeClass('d-none');

                        $('#btnLoading').addClass('d-none');

                        $('#btnAmbil').prop('disabled', false);

                    }

                });

            });

        });

    </script>

</body>

</html>