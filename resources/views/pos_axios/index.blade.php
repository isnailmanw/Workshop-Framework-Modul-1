@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Point Of Sales (Axios)</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <label>Kode Barang</label>

                    <div class="input-group">
                        <input type="text" id="kode_barang" class="form-control">

                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span id="spinner_cari" class="spinner-border spinner-border-sm d-none"></span>
                            </span>
                        </div>

                    </div>

                    <br>

                    <label>Nama Barang</label>
                    <input type="text" id="nama_barang" class="form-control" readonly>

                    <br>

                    <label>Harga Barang</label>
                    <input type="text" id="harga_barang" class="form-control" readonly>

                    <br>

                    <label>Jumlah</label>
                    <input type="number" id="jumlah" class="form-control" value="1">

                    <br>

                    <button id="btn_tambah" class="btn btn-success" disabled>

                        <span id="text_tambah">Tambahkan</span>
                        <span id="spinner_tambah" class="spinner-border spinner-border-sm d-none"></span>

                    </button>

                </div>

            </div>

            <br><br>

            <table class="table table-bordered" id="table-pos">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody></tbody>

            </table>

            <h4>Total : <span id="total">0</span></h4>

            <br>

            <button id="btn_bayar" class="btn btn-primary">

                <span id="text_bayar">Bayar</span>
                <span id="spinner_bayar" class="spinner-border spinner-border-sm d-none"></span>

            </button>

        </div>
    </div>

@endsection



@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {

            /* =================================
            ENTER UNTUK CARI BARANG
            ================================= */

            document.getElementById("kode_barang").addEventListener("keydown", function (e) {

                if (e.key === "Enter") {

                    e.preventDefault();

                    let kode = this.value;

                    if (kode === "") return;

                    document.getElementById("spinner_cari").classList.remove("d-none");

                    axios.post("{{ route('pos.barang') }}", {

                        _token: "{{ csrf_token() }}",
                        kode: kode

                    })

                        .then(function (response) {

                            let data = response.data;

                            document.getElementById("spinner_cari").classList.add("d-none");

                            if (data) {

                                document.getElementById("nama_barang").value = data.nama;
                                document.getElementById("harga_barang").value = data.harga;
                                document.getElementById("jumlah").value = 1;

                                document.getElementById("btn_tambah").disabled = false;

                            } else {

                                Swal.fire({
                                    icon: "error",
                                    title: "Barang tidak ditemukan"
                                });

                                clearForm();

                            }

                        })

                        .catch(function () {

                            document.getElementById("spinner_cari").classList.add("d-none");

                            Swal.fire({
                                icon: "error",
                                title: "Terjadi kesalahan saat mencari barang"
                            });

                        });

                }

            });



            /* =================================
            TAMBAH KE TABEL
            ================================= */

            document.getElementById("btn_tambah").addEventListener("click", function () {

                document.getElementById("spinner_tambah").classList.remove("d-none");
                this.disabled = true;

                setTimeout(function () {

                    let kode = document.getElementById("kode_barang").value;
                    let nama = document.getElementById("nama_barang").value;
                    let harga = parseInt(document.getElementById("harga_barang").value);
                    let jumlah = parseInt(document.getElementById("jumlah").value);

                    let subtotal = harga * jumlah;

                    let found = false;

                    document.querySelectorAll("#table-pos tbody tr").forEach(function (row) {

                        let kodeRow = row.children[0].innerText;

                        if (kodeRow == kode) {

                            let qty = row.querySelector(".qty").value;

                            qty = parseInt(qty) + jumlah;

                            row.querySelector(".qty").value = qty;

                            row.querySelector(".subtotal").innerText = qty * harga;

                            found = true;

                        }

                    });

                    if (!found) {

                        let row = `
            <tr>

            <td>${kode}</td>
            <td>${nama}</td>
            <td>${harga}</td>

            <td>
            <input type="number" class="form-control qty" value="${jumlah}">
            </td>

            <td class="subtotal">${subtotal}</td>

            <td>

            <button class="btn btn-danger btn-hapus">

            <span>Hapus</span>
            <span class="spinner-border spinner-border-sm d-none spinner-hapus"></span>

            </button>

            </td>

            </tr>
            `;

                        document.querySelector("#table-pos tbody").insertAdjacentHTML("beforeend", row);

                    }

                    hitungTotal();
                    clearForm();

                    document.getElementById("spinner_tambah").classList.add("d-none");

                }, 300);

            });



            /* =================================
            HITUNG TOTAL
            ================================= */

            function hitungTotal() {

                let total = 0;

                document.querySelectorAll(".subtotal").forEach(function (el) {

                    total += parseInt(el.innerText);

                });

                document.getElementById("total").innerText = total;

            }



            /* =================================
            UPDATE JUMLAH
            ================================= */

            document.addEventListener("change", function (e) {

                if (e.target.classList.contains("qty")) {

                    let row = e.target.closest("tr");

                    let harga = row.children[2].innerText;

                    let qty = e.target.value;

                    row.querySelector(".subtotal").innerText = harga * qty;

                    hitungTotal();

                }

            });



            /* =================================
            HAPUS BARIS
            ================================= */

            document.addEventListener("click", function (e) {

                if (e.target.closest(".btn-hapus")) {

                    let btn = e.target.closest(".btn-hapus");

                    btn.querySelector(".spinner-hapus").classList.remove("d-none");

                    setTimeout(function () {

                        btn.closest("tr").remove();

                        hitungTotal();

                    }, 300);

                }

            });



            /* =================================
            BAYAR TRANSAKSI
            ================================= */

            document.getElementById("btn_bayar").addEventListener("click", function () {

                if (document.querySelectorAll("#table-pos tbody tr").length == 0) {

                    Swal.fire({
                        icon: "warning",
                        title: "Keranjang kosong"
                    });

                    return;

                }

                document.getElementById("spinner_bayar").classList.remove("d-none");
                this.disabled = true;

                let items = [];

                document.querySelectorAll("#table-pos tbody tr").forEach(function (row) {

                    let kode = row.children[0].innerText;
                    let jumlah = row.querySelector(".qty").value;
                    let subtotal = row.querySelector(".subtotal").innerText;

                    items.push({
                        id_barang: kode,
                        jumlah: jumlah,
                        subtotal: subtotal
                    });

                });

                let total = document.getElementById("total").innerText;

                axios.post("{{ route('pos.simpan') }}", {

                    _token: "{{ csrf_token() }}",
                    items: items,
                    total: total

                })

                    .then(function () {

                        document.getElementById("spinner_bayar").classList.add("d-none");
                        document.getElementById("btn_bayar").disabled = false;

                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Transaksi berhasil disimpan"
                        });

                        document.querySelector("#table-pos tbody").innerHTML = "";
                        document.getElementById("total").innerText = 0;

                    })

                    .catch(function () {

                        document.getElementById("spinner_bayar").classList.add("d-none");
                        document.getElementById("btn_bayar").disabled = false;

                        Swal.fire({
                            icon: "error",
                            title: "Gagal menyimpan transaksi"
                        });

                    });

            });



            /* =================================
            CLEAR FORM
            ================================= */

            function clearForm() {

                document.getElementById("kode_barang").value = "";
                document.getElementById("nama_barang").value = "";
                document.getElementById("harga_barang").value = "";
                document.getElementById("jumlah").value = 1;

                document.getElementById("btn_tambah").disabled = true;

                document.getElementById("kode_barang").focus();

            }

        });

    </script>

@endsection