<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembelian</title>

    <style>
        body {
            font-family: monospace;
            background: #eee;
        }

        .struk {
            width: 80mm;
            background: white;
            padding: 10px;
            margin: auto;
        }

        .center {
            text-align: center;
        }

        hr {
            border: none;
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            margin-top: 10px;
            text-align: center;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        @media print {
            body {
                background: white;
            }

            .btn {
                display: none;
            }

            .struk {
                margin: 0;
                width: 80mm;
            }
        }
    </style>
</head>

<body>

    <div class="struk">

        <div class="center">
            <b>KANTIN ONLINE</b><br>
        </div>

        <p>ID: {{ $order->id }}</p>

        <hr>

        {{-- 🔥 LIST MENU --}}
        @foreach($order->details as $d)
            <div>
                {{-- 🔥 FIX AMAN: kalau relasi null tidak error --}}
                {{ optional($d->menu)->nama ?? optional($d->menu)->nama_menu ?? 'Menu tidak ditemukan' }}

                <div class="row">
                    <span>{{ $d->qty }} x</span>
                    <span>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach

        <hr>

        <div class="row">
            <b>Total</b>
            <b>Rp {{ number_format($order->total, 0, ',', '.') }}</b>
        </div>

        <hr>

        <div class="center">
            {{-- 🔥 QR CODE (KOTAK) --}}
            <img src="{{ $qrcode }}" width="120">
            <br>
            Terima kasih 🙏
        </div>

        <div class="btn">
            <button onclick="printStruk()">🖨 Cetak / Save PDF</button>
        </div>

    </div>

</body>

</html>

<script>
    function printStruk() {
        window.print();

        // 🔥 FIX: redirect setelah print ditutup
        setTimeout(function () {
            window.location.href = "/kantin";
        }, 1000);
    }
</script>