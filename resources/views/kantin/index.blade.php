@extends('layouts.app')

@section('content')

    <div class="container py-4">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">🍽️ Kantin Online</h3>
                <small class="text-muted">Pesan makanan favoritmu dengan mudah</small>
            </div>

            <a href="/login" class="btn btn-outline-primary rounded-3 px-4">
                Login
            </a>
        </div>

        <div class="row g-4">

            <!-- FORM -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">

                        <h5 class="mb-4 fw-semibold">🧾 Pilih Menu</h5>

                        <!-- Vendor -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Vendor</label>
                            <select id="vendor" class="form-select rounded-3" onchange="loadMenu()">
                                <option value="">-- Pilih Vendor --</option>
                                @foreach($vendors as $v)
                                    <option value="{{ $v->id }}">{{ $v->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Menu -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Menu</label>
                            <select id="menu" class="form-select rounded-3" onchange="setHarga()">
                                <option value="">-- Pilih Menu --</option>
                            </select>
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label class="form-label fw-medium">Harga</label>
                            <input type="text" id="harga" class="form-control bg-light rounded-3" readonly>
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-4">
                            <label class="form-label fw-medium">Jumlah</label>
                            <input type="number" id="jumlah" class="form-control rounded-3" placeholder="Masukkan jumlah">
                        </div>

                        <button onclick="tambahBarang()" class="btn btn-primary w-100 rounded-3 py-2">
                            + Tambah ke Keranjang
                        </button>

                    </div>
                </div>
            </div>

            <!-- KERANJANG -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">

                        <h5 class="mb-4 fw-semibold">🛒 Keranjang</h5>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Menu</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="tabelBarang"></tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded-3">
                            <h5 class="mb-0">
                                Total: <span id="total" class="text-primary fw-bold">Rp 0</span>
                            </h5>

                            <div>
                                <button onclick="bayar()" class="btn btn-success px-4 py-2 rounded-3">
                                    💳 Bayar
                                </button>

                                <button onclick="cekStatusManual()" class="btn btn-dark px-4 py-2 rounded-3 mt-2">
                                    🔍 Check Status
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    let total = 0;
    let menus = [];
    let keranjang = [];
    let currentOrderId = null;

    function showLoading(text = 'Loading...') {
        Swal.fire({
            title: text,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function loadMenu() {
        let vendorId = document.getElementById('vendor').value;

        fetch('/get-menu/' + vendorId)
            .then(res => res.json())
            .then(data => {

                menus = data;
                let menuSelect = document.getElementById('menu');
                menuSelect.innerHTML = '<option value="">-- Pilih Menu --</option>';

                data.forEach(m => {
                    menuSelect.innerHTML += `
                    <option value="${m.id}">
                        ${m.nama_menu} - Rp ${m.harga}
                    </option>
                `;
                });
            });
    }

    function setHarga() {
        let menuId = document.getElementById('menu').value;
        let selected = menus.find(m => m.id == parseInt(menuId));

        if (selected) {
            document.getElementById('harga').value = "Rp " + selected.harga.toLocaleString();
            document.getElementById('harga').dataset.value = selected.harga;
        }
    }

    function tambahBarang() {

        showLoading('Menambahkan ke keranjang...');

        setTimeout(() => {

            let menuId = document.getElementById('menu').value;
            let menuText = document.getElementById('menu').selectedOptions[0].text;
            let harga = parseInt(document.getElementById('harga').dataset.value);
            let jumlah = parseInt(document.getElementById('jumlah').value);

            if (!menuId || !harga || !jumlah) {
                Swal.fire('Oops!', 'Lengkapi data dulu ya!', 'warning');
                return;
            }

            let subtotal = harga * jumlah;
            total += subtotal;

            keranjang.push({
                menu_id: menuId,
                qty: jumlah,
                subtotal: subtotal
            });

            let row = `
            <tr>
                <td>${menuText}</td>
                <td>Rp ${harga.toLocaleString()}</td>
                <td>${jumlah}</td>
                <td class="fw-semibold text-success">Rp ${subtotal.toLocaleString()}</td>
            </tr>
        `;

            document.getElementById('tabelBarang').innerHTML += row;
            document.getElementById('total').innerText = "Rp " + total.toLocaleString();

            document.getElementById('jumlah').value = '';

            Swal.close();

        }, 500);
    }

    function bayar() {

        if (keranjang.length === 0) {
            Swal.fire('Keranjang kosong!', 'Tambahkan menu dulu ya', 'warning');
            return;
        }

        showLoading('Memproses pembayaran...');

        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items: keranjang,
                total: total
            })
        })
            .then(res => res.json())
            .then(data => {

                currentOrderId = data.order_id;

                fetch('/bayar-midtrans/' + currentOrderId)
                    .then(res => res.json())
                    .then(result => {

                        Swal.close();

                        snap.pay(result.snap_token, {

                            onSuccess: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Klik Check Status untuk update'
                                });
                            },

                            onPending: function () {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Menunggu Pembayaran',
                                    text: 'Silakan klik Check Status'
                                });
                            },

                            onError: function () {
                                Swal.fire('Gagal', 'Pembayaran gagal ❌', 'error');
                            }

                        });

                    });

            });
    }

    let demoMode = true;

    function cekStatusManual() {

        if (!currentOrderId) {
            Swal.fire('Oops!', 'Belum ada transaksi', 'warning');
            return;
        }

        if (demoMode) {

            showLoading('Memproses pembayaran...');

            fetch('/fake-success/' + currentOrderId)
                .then(res => res.json())
                .then(() => {

                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: 'Status: LUNAS 🎉'
                    }).then(() => {
                        location.reload(); // 🔥 penting biar vendor ikut update
                    });

                });

            return;
        }

        fetch('/fake-success/' + currentOrderId)
            .then(res => res.json())
            .then(data => {

                if (data.status === 'settlement') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: 'Status: LUNAS 🎉'
                    }).then(() => {
                        location.reload();
                    });

                } else if (data.status === 'pending') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Masih Pending',
                        text: 'Belum dibayar'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.status
                    });
                }

            });
    }
    
    console.log("ORDER ID:", currentOrderId);
</script>