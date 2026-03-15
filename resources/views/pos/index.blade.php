@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Point Of Sales</h3>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(document).ready(function () {

            /* =================================
            ENTER UNTUK CARI BARANG
            ================================= */

            $('#kode_barang').keydown(function (e) {

                if (e.key === "Enter") {

                    e.preventDefault();

                    let kode = $(this).val();

                    if (kode === "") return;

                    $('#spinner_cari').removeClass('d-none');

                    $.ajax({

                        url: "{{ route('pos.barang') }}",
                        type: "POST",

                        data: {
                            _token: "{{ csrf_token() }}",
                            kode: kode
                        },

                        success: function (data) {

                            $('#spinner_cari').addClass('d-none');

                            if (data) {

                                $('#nama_barang').val(data.nama);
                                $('#harga_barang').val(data.harga);
                                $('#jumlah').val(1);

                                $('#btn_tambah').prop('disabled', false);

                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Barang tidak ditemukan'
                                });

                                clearForm();

                            }

                        },

                        error: function () {

                            $('#spinner_cari').addClass('d-none');

                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat mencari barang'
                            });

                        }

                    });

                }

            });



            /* =================================
            TAMBAH KE TABEL
            ================================= */

            $('#btn_tambah').click(function () {

                $('#spinner_tambah').removeClass('d-none');
                $('#btn_tambah').prop('disabled', true);

                setTimeout(function () {

                    let kode = $('#kode_barang').val();
                    let nama = $('#nama_barang').val();
                    let harga = parseInt($('#harga_barang').val());
                    let jumlah = parseInt($('#jumlah').val());

                    let subtotal = harga * jumlah;

                    let found = false;

                    $('#table-pos tbody tr').each(function () {

                        let kodeRow = $(this).find('td:eq(0)').text();

                        if (kodeRow == kode) {

                            let qty = parseInt($(this).find('.qty').val());

                            qty = qty + jumlah;

                            $(this).find('.qty').val(qty);

                            let newSubtotal = qty * harga;

                            $(this).find('.subtotal').text(newSubtotal);

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

                                                            <span class="text">Hapus</span>

                                                            <span class="spinner-border spinner-border-sm d-none spinner-hapus"></span>

                                                            </button>

                                                            </td>

                                                            </tr>
                                                            `;

                        $('#table-pos tbody').append(row);

                    }

                    hitungTotal();
                    clearForm();

                    $('#spinner_tambah').addClass('d-none');

                }, 300);

            });



            /* =================================
            HITUNG TOTAL
            ================================= */

            function hitungTotal() {

                let total = 0;

                $('.subtotal').each(function () {

                    total += parseInt($(this).text());

                });

                $('#total').text(total);

            }



            /* =================================
            UPDATE JUMLAH
            ================================= */

            $(document).on('change', '.qty', function () {

                let harga = $(this).closest('tr').find('td:eq(2)').text();

                let qty = $(this).val();

                let subtotal = harga * qty;

                $(this).closest('tr').find('.subtotal').text(subtotal);

                hitungTotal();

            });



            /* =================================
            HAPUS BARIS
            ================================= */

            $(document).on('click', '.btn-hapus', function () {

                let btn = $(this);

                btn.find('.spinner-hapus').removeClass('d-none');

                setTimeout(function () {

                    btn.closest('tr').remove();

                    hitungTotal();

                }, 300);

            });



            /* =================================
            BAYAR TRANSAKSI
            ================================= */

            $('#btn_bayar').click(function () {

                if ($('#table-pos tbody tr').length == 0) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Keranjang kosong'
                    });

                    return;

                }

                $('#spinner_bayar').removeClass('d-none');
                $('#btn_bayar').prop('disabled', true);

                let items = [];

                $('#table-pos tbody tr').each(function () {

                    let kode = $(this).find('td:eq(0)').text();
                    let jumlah = $(this).find('.qty').val();
                    let subtotal = $(this).find('.subtotal').text();

                    items.push({
                        id_barang: kode,
                        jumlah: jumlah,
                        subtotal: subtotal
                    });

                });

                let total = $('#total').text();

                $.ajax({

                    url: "{{ route('pos.simpan') }}",
                    type: "POST",
                    contentType: "application/json",

                    data: JSON.stringify({
                        _token: "{{ csrf_token() }}",
                        items: items,
                        total: total
                    }),

                    success: function () {

                        $('#spinner_bayar').addClass('d-none');
                        $('#btn_bayar').prop('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Transaksi berhasil disimpan'
                        });

                        $('#table-pos tbody').empty();
                        $('#total').text(0);

                    },

                    error: function (xhr) {

                        $('#spinner_bayar').addClass('d-none');
                        $('#btn_bayar').prop('disabled', false);

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan transaksi'
                        });

                    }

                });

            });



            /* =================================
            CLEAR FORM
            ================================= */

            function clearForm() {

                $('#kode_barang').val('');
                $('#nama_barang').val('');
                $('#harga_barang').val('');
                $('#jumlah').val(1);

                $('#btn_tambah').prop('disabled', true);

                $('#kode_barang').focus();

            }

        });

    </script>

@endsection