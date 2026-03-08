@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Modul HTML DOM - DataTables</h4>

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

                    <table class="table table-striped" id="tabelBarang">

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

        $(document).ready(function () {

            let table = $('#tabelBarang').DataTable();

            $('#btnSubmit').click(function () {

                let form = document.getElementById("formBarang");

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                let btn = document.getElementById("btnSubmit");

                btn.innerHTML = "Loading...";
                btn.disabled = true;

                setTimeout(function () {

                    let nama = $('#namaBarang').val();
                    let harga = $('#hargaBarang').val();

                    table.row.add([
                        idBarang,
                        nama,
                        "Rp " + harga
                    ]).draw(false);

                    idBarang++;

                    $('#namaBarang').val("");
                    $('#hargaBarang').val("");

                    btn.innerHTML = "Submit";
                    btn.disabled = false;

                }, 500);

            });


            $('#tabelBarang tbody').on('click', 'tr', function () {

                let data = table.row(this).data();

                document.getElementById("editId").value = data[0];
                document.getElementById("editNama").value = data[1];
                document.getElementById("editHarga").value = data[2].replace("Rp ", "");
                document.getElementById("editIndex").value = table.row(this).index();

                alert("Row dipilih : " + data[0] + " - " + data[1]);

                let modal = new bootstrap.Modal(document.getElementById('modalEdit'));
                modal.show();

            });


            document.getElementById("btnUbah").onclick = function () {

                let index = document.getElementById("editIndex").value;

                let nama = document.getElementById("editNama").value;
                let harga = document.getElementById("editHarga").value;

                table.row(index).data([
                    document.getElementById("editId").value,
                    nama,
                    "Rp " + harga
                ]).draw();

                bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();

            };


            document.getElementById("btnHapus").onclick = function () {

                let index = document.getElementById("editIndex").value;

                table.row(index).remove().draw();

                bootstrap.Modal.getInstance(document.getElementById('modalEdit')).hide();

            };

        });

    </script>

@endsection