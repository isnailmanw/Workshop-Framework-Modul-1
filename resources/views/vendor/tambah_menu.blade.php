@extends('layouts.app')

@section('content')

    <style>
        :root {
            --primary: #a78bfa;
            --primary-dark: #7c3aed;
            --primary-soft: #ede9fe;
            --bg: #f9fafb;
        }

        /* 🔥 BACKGROUND */
        body {
            background: var(--bg);
        }

        /* 🔥 CARD */
        .card-custom {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.08);
        }

        /* 🔥 BUTTON */
        .btn-purple {
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            color: white;
            border: none;
            border-radius: 12px;
        }

        .btn-purple:hover {
            opacity: 0.9;
            color: white;
        }

        /* 🔥 BACK BUTTON */
        .btn-back {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* 🔥 INPUT */
        .form-control {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #a78bfa;
            box-shadow: 0 0 0 2px rgba(167, 139, 250, 0.2);
        }

        /* 🔥 MENU CARD */
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(124, 58, 237, 0.08);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 25px rgba(124, 58, 237, 0.15);
        }

        .menu-price {
            color: #7c3aed;
            font-weight: bold;
        }

        .menu-actions a {
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 8px;
        }

        /* 🔥 LOADING */
        .loading {
            font-size: 14px;
            color: #7c3aed;
        }
    </style>

    <div class="container py-4">

        <!-- 🔥 HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold" style="color:#4c1d95;">🍽️ Kelola Menu</h3>

            <a href="/vendor/dashboard" class="btn btn-back">
                ⬅ Dashboard
            </a>
        </div>

        <!-- 🔥 FORM -->
        <div class="card-custom mb-4">

            <h5 class="mb-3 fw-bold">Tambah Menu</h5>

            <form action="{{ isset($menu) ? '/menu/update/' . $menu->id : '/menu/store' }}" method="POST" id="formMenu">
                @csrf

                <div class="mb-3">
                    <label class="mb-1">Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="mb-1">Harga</label>
                    <input type="number" name="harga" class="form-control" value="{{ $menu->harga ?? '' }}" required>
                </div>

                <button class="btn btn-purple px-4" id="btnSubmit">
                    💾 Simpan
                </button>

                <div id="loading" class="loading mt-2" style="display:none;">
                    ⏳ Menyimpan...
                </div>

            </form>

        </div>

        <!-- 🔥 LIST MENU -->
        <div class="card-custom">

            <h5 class="mb-3 fw-bold">Daftar Menu</h5>

            <div class="row g-3">

                @foreach($menus as $m)
                    <div class="col-md-6">

                        <div class="menu-card d-flex justify-content-between align-items-center">

                            <div>
                                <div class="fw-semibold">
                                    {{ $m->nama_menu }}
                                </div>

                                <div class="menu-price">
                                    Rp {{ number_format($m->harga) }}
                                </div>
                            </div>

                            <div class="menu-actions d-flex gap-1">
                                <a href="/menu/edit/{{ $m->id }}" class="btn btn-warning btn-sm">Edit</a>

                                <a href="/menu/delete/{{ $m->id }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus menu?')">
                                    Hapus
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>

    <!-- 🔥 SCRIPT SPINNER -->
    <script>
        document.getElementById('formMenu').addEventListener('submit', function () {
            document.getElementById('btnSubmit').style.display = 'none';
            document.getElementById('loading').style.display = 'block';
        });
    </script>

    @if(session('error'))
        <div class="alert alert-danger m-3">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success m-3">
            {{ session('success') }}
        </div>
    @endif

@endsection