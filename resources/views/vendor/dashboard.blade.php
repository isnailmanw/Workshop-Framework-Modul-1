@extends('layouts.app')

@section('content')

    <style>
        /* 🌸 WARNA UTAMA (SESUAI TEMPLATE PURPLE) */
        :root {
            --primary: #a78bfa;
            --primary-soft: #e9bef0;
            --primary-dark: #7c3aed;
            --secondary: #f472b6;
            --bg-card: #e9bdee;
        }

        /* 🔥 CARD UTAMA */
        .main-card {
            background: var(--bg-card);
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(226, 193, 235, 0.08);
        }

        /* 🔥 HOVER EFFECT */
        .hover-card {
            transition: all 0.3s ease;
            border-radius: 20px;
        }

        .hover-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(124, 58, 237, 0.15);
        }

        /* 🔥 ICON BOX */
        .icon-box {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* 💜 GRADIENT UNGU (MAIN) */
        .bg-purple {
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
        }

        /* 💖 GRADIENT PINK SOFT */
        .bg-pink {
            background: linear-gradient(135deg, #f9a8d4, #f472b6);
        }

        /* 🔥 TAMBAHAN UNTUK SCAN */
        .bg-scan {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        /* 🌸 TEXT */
        .title {
            color: #4c1d95;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
        }
    </style>

    <div class="container-fluid py-4">

        <!-- 🔥 HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold title">🏪 Dashboard Vendor</h3>
            <p class="subtitle">Kelola menu & pesanan dengan tampilan modern</p>
        </div>

        <!-- 🔥 CARD WRAPPER -->
        <div class="card main-card border-0">
            <div class="card-body p-5">

                <div class="row g-4">

                    <!-- 🔥 TAMBAH MENU -->
                    <div class="col-md-4">
                        <a href="/menu/create" class="text-decoration-none">
                            <div class="card border-0 shadow-sm hover-card h-100">

                                <div class="card-body text-center p-5">

                                    <div class="icon-box bg-purple mb-4">
                                        🍽️
                                    </div>

                                    <h5 class="fw-bold text-dark">Tambah Menu</h5>
                                    <p class="text-muted mb-0">
                                        Tambahkan menu baru untuk dijual
                                    </p>

                                </div>

                            </div>
                        </a>
                    </div>

                    <!-- 🔥 LIHAT PESANAN -->
                    <div class="col-md-4">
                        <a href="/vendor" class="text-decoration-none">
                            <div class="card border-0 shadow-sm hover-card h-100">

                                <div class="card-body text-center p-5">

                                    <div class="icon-box bg-pink mb-4">
                                        📋
                                    </div>

                                    <h5 class="fw-bold text-dark">Lihat Pesanan</h5>
                                    <p class="text-muted mb-0">
                                        Kelola pesanan customer
                                    </p>

                                </div>

                            </div>
                        </a>
                    </div>

                    <!-- 🔥 🔥 TAMBAHAN: SCAN QR -->
                    <div class="col-md-4">
                        <a href="/vendor/scan" class="text-decoration-none">
                            <div class="card border-0 shadow-sm hover-card h-100">

                                <div class="card-body text-center p-5">

                                    <div class="icon-box bg-scan mb-4">
                                        📷
                                    </div>

                                    <h5 class="fw-bold text-dark">Scan QR Pesanan</h5>
                                    <p class="text-muted mb-0">
                                        Scan QR dari customer untuk melihat pesanan
                                    </p>

                                </div>

                            </div>
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection