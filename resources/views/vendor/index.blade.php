@extends('layouts.app')

@section('content')

    <style>
        :root {
            --primary: #a78bfa;
            --primary-dark: #7c3aed;
            --primary-soft: #ede9fe;
            --pink: #f472b6;
            --bg: #f9fafb;
        }

        /* 🔥 BACKGROUND */
        body {
            background: var(--bg);
        }

        /* 🔥 HEADER */
        .page-header h3 {
            color: #4c1d95;
        }

        /* 🔥 BUTTON BACK */
        .btn-back {
            background: white;
            border-radius: 12px;
            padding: 6px 14px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* 🔥 FILTER */
        .filter-wrap {
            display: flex;
            gap: 10px;
        }

        .filter-btn {
            border-radius: 20px;
            padding: 6px 18px;
            font-size: 14px;
            background: #f3f4f6;
            border: none;
            transition: 0.3s;
        }

        .filter-btn.active {
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            color: white;
            box-shadow: 0 6px 15px rgba(124, 58, 237, 0.3);
        }

        /* 🔥 CARD PESANAN */
        .order-card {
            border-radius: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.08);
            transition: 0.3s;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px rgba(124, 58, 237, 0.15);
        }

        /* 🔥 STATUS */
        .status {
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 12px;
        }

        .lunas {
            background: #d1fae5;
            color: #065f46;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        /* 🔥 DETAIL */
        .detail-item {
            background: #f9fafb;
            padding: 6px 10px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 13px;
        }
    </style>

    <div class="container py-4">

        <!-- 🔥 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4 page-header">
            <div>
                <h3 class="fw-bold">📋 Data Pesanan</h3>
                <p class="text-muted mb-0">Kelola pesanan dengan tampilan modern</p>
            </div>

            <a href="/vendor/dashboard" class="btn btn-back">
                ⬅ Dashboard
            </a>
        </div>

        <!-- 🔥 FILTER -->
        <div class="filter-wrap mb-4">

            <a href="/vendor" class="filter-btn {{ request()->is('vendor') ? 'active' : '' }}">
                Semua
            </a>

            <a href="/vendor/lunas" class="filter-btn {{ request()->is('vendor/lunas') ? 'active' : '' }}">
                Lunas
            </a>

        </div>

        <!-- 🔥 LIST PESANAN -->
        <div class="row g-4">

            @forelse($orders as $o)
                <div class="col-md-6">

                    <div class="order-card">

                        <!-- HEADER -->
                        <div class="d-flex justify-content-between mb-2">
                            <strong>#{{ $o->id }}</strong>

                            @if($o->status_pembayaran == 'lunas')
                                <span class="status lunas">✔ Lunas</span>
                            @else
                                <span class="status pending">⏳ Pending</span>
                            @endif
                        </div>

                        <!-- CUSTOMER -->
                        <div class="mb-2">
                            <small class="text-muted">Customer</small><br>
                            <b>{{ $o->nama_customer }}</b>
                        </div>

                        <!-- TOTAL -->
                        <div class="mb-3">
                            <small class="text-muted">Total</small><br>
                            <b style="color:#7c3aed;">
                                Rp {{ number_format($o->total) }}
                            </b>
                        </div>

                        <!-- DETAIL -->
                        <div>
                            <small class="text-muted">Detail</small>

                            @foreach($o->details as $d)
                                <div class="detail-item">
                                    {{ $d->menu->nama_menu }} x{{ $d->qty }}
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            @empty
                <div class="text-center text-muted">
                    Belum ada pesanan
                </div>
            @endforelse

        </div>

    </div>

@endsection