@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Modul HTML DOM - Table Biasa</h4>

                <form id="formBarang">

                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label>Nama Barang</label>
                            <input type="text" id="namaBarang" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label>Harga Barang</label>
                            <input type="number" id="hargaBarang" class="form-control" required>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">

                            <button type="button" id="btnSubmit" class="btn btn-gradient-primary">
                                Submit
                            </button>

                        </div>

                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered" id="tabelBarang">

                        <thead>
                            <tr>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>

                </div>

            </div>
        </div>

    </div>


    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editIndex">

                    <div class="form-group mb-3">
                        <label>ID Barang</label>
                        <input type="text" id="editId" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" id="editNama" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga</label>
                        <input type="number" id="editHarga" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button id="btnUbah" class="btn btn-warning">
                        Ubah
                    </button>

                    <button id="btnHapus" class="btn btn-danger">
                        Hapus
                    </button>

                </div>

            </div>
        </div>
    </div>

@endsection


@section('js-page')

    <style>
        #tabelBarang tbody tr {
            cursor: pointer;
        }
    </style>

    <script>

        let idBarang = 1;

        document.getElementById("btnSubmit").onclick = function () {

            let form = document.getElementById("formBarang");

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let btn = document.getElementById("btnSubmit");

            btn.innerHTML = "Loading...";
            btn.disabled = true;

            setTimeout(function () {

                let nama = document.getElementById("namaBarang").value;
                let harga = document.getElementById("hargaBarang").value;

                let table = document
                    .getElementById("tabelBarang")
                    .getElementsByTagName("tbody")[0];

                let row = table.insertRow();

                row.insertCell(0).innerHTML = idBarang;
                row.insertCell(1).innerHTML = nama;
                row.insertCell(2).innerHTML = "Rp " + harga;

                idBarang++;

                document.getElementById("namaBarang").value = "";
                document.getElementById("hargaBarang").value = "";

                btn.innerHTML = "Submit";
                btn.disabled = false;

            }, 500);

        };


        document.querySelector("#tabelBarang tbody").addEventListener("click", function (e) {

            let row = e.target.closest("tr");

            let id = row.cells[0].innerHTML;
            let nama = row.cells[1].innerHTML;
            let harga = row.cells[2].innerHTML;

            document.getElementById("editId").value = id;
            document.getElementById("editNama").value = nama;
            document.getElementById("editHarga").value = harga.replace("Rp ", "");
            document.getElementById("editIndex").value = row.rowIndex;

            alert("Row dipilih : " + id + " - " + nama);

            let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
            modal.show();

        });


        document.getElementById("btnUbah").onclick = function () {

            let index = document.getElementById("editIndex").value;

            let table = document.getElementById("tabelBarang");

            let row = table.rows[index];

            row.cells[1].innerHTML = document.getElementById("editNama").value;
            row.cells[2].innerHTML = "Rp " + document.getElementById("editHarga").value;

            bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();

        };


        document.getElementById("btnHapus").onclick = function () {

            let index = document.getElementById("editIndex").value;

            document.getElementById("tabelBarang").deleteRow(index);

            bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();

        };

    </script>

@endsection