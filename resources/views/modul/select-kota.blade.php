@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="row">

            <!-- CARD SELECT -->
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Select</h4>

                        <div class="form-group mb-3">
                            <label>Kota</label>
                            <input type="text" id="inputKota" class="form-control">
                        </div>

                        <button id="btnTambahKota" class="btn btn-gradient-primary mb-3">
                            Tambahkan
                        </button>

                        <div class="form-group mb-3">

                            <label>Select Kota</label>

                            <select id="selectKota" class="form-control">

                                <option value="">-- Pilih Kota --</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label>Kota Terpilih</label>
                            <input type="text" id="hasilKota" class="form-control" readonly>

                        </div>

                    </div>
                </div>

            </div>



            <!-- CARD SELECT2 -->
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Select 2</h4>

                        <div class="form-group mb-3">
                            <label>Kota</label>
                            <input type="text" id="inputKota2" class="form-control">
                        </div>

                        <button id="btnTambahKota2" class="btn btn-gradient-primary mb-3">
                            Tambahkan
                        </button>

                        <div class="form-group mb-3">

                            <label>Select Kota</label>

                            <select id="selectKota2" class="form-control select2">

                                <option value="">-- Pilih Kota --</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label>Kota Terpilih</label>
                            <input type="text" id="hasilKota2" class="form-control" readonly>

                        </div>

                    </div>
                </div>

            </div>


        </div>

    </div>

@endsection



@section('js-page')

    <script>

        $(document).ready(function () {

            $('#selectKota2').select2({
                placeholder: "Cari atau pilih kota",
                allowClear: true,
                width: '100%'
            });

        });


        document.getElementById("btnTambahKota").onclick = function () {

            let kota = document.getElementById("inputKota").value;

            if (kota == "") {
                alert("Nama kota harus diisi");
                return;
            }

            let select = document.getElementById("selectKota");

            let option = document.createElement("option");

            option.value = kota;
            option.text = kota;

            select.appendChild(option);

            document.getElementById("inputKota").value = "";

        };


        document.getElementById("selectKota").onchange = function () {

            document.getElementById("hasilKota").value = this.value;

        };



        document.getElementById("btnTambahKota2").onclick = function () {

            let kota = document.getElementById("inputKota2").value;

            if (kota == "") {
                alert("Nama kota harus diisi");
                return;
            }

            let select = document.getElementById("selectKota2");

            let option = document.createElement("option");

            option.value = kota;
            option.text = kota;

            select.appendChild(option);

            $('#selectKota2').trigger('change');

            document.getElementById("inputKota2").value = "";

        };


        document.getElementById("selectKota2").onchange = function () {

            document.getElementById("hasilKota2").value = this.value;

        };

    </script>

@endsection