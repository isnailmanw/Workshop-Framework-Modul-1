@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Cascading Select Wilayah</h3>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Pilih Wilayah</h4>

                    <div class="row">

                        <div class="col-md-3">
                            <label>Provinsi</label>
                            <select class="form-control" id="provinsi">

                                <option value="">Pilih Provinsi</option>

                                @foreach($provinsi as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach

                            </select>
                        </div>


                        <div class="col-md-3">
                            <label>Kabupaten / Kota</label>
                            <select class="form-control" id="kabupaten">
                                <option value="">Pilih Kabupaten</option>
                            </select>
                        </div>


                        <div class="col-md-3">
                            <label>Kecamatan</label>
                            <select class="form-control" id="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>


                        <div class="col-md-3">
                            <label>Kelurahan</label>
                            <select class="form-control" id="kelurahan">
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>

                    </div>

                    <hr>

                    <h5>Hasil Wilayah Dipilih</h5>

                    <p>Provinsi : <span id="hasil_provinsi">-</span></p>
                    <p>Kabupaten : <span id="hasil_kabupaten">-</span></p>
                    <p>Kecamatan : <span id="hasil_kecamatan">-</span></p>
                    <p>Kelurahan : <span id="hasil_kelurahan">-</span></p>

                </div>
            </div>

        </div>
    </div>

@endsection



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>

    $(document).ready(function () {

        /* =======================
        PROVINSI -> KABUPATEN
        ======================= */

        $('#provinsi').change(function () {

            let id = $(this).val();
            let text = $("#provinsi option:selected").text();

            $('#hasil_provinsi').text(text);
            $('#hasil_kabupaten').text("-");
            $('#hasil_kecamatan').text("-");
            $('#hasil_kelurahan').text("-");

            $.ajax({

                url: "{{ route('wilayah.kabupaten') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },

                success: function (data) {

                    $('#kabupaten').empty();
                    $('#kabupaten').append('<option>Pilih Kabupaten</option>');

                    $.each(data, function (key, val) {

                        $('#kabupaten').append(
                            '<option value="' + val.id + '">' + val.name + '</option>'
                        );

                    });

                }

            });

        });


        /* =======================
        KABUPATEN -> KECAMATAN
        ======================= */

        $('#kabupaten').change(function () {

            let id = $(this).val();
            let text = $("#kabupaten option:selected").text();

            $('#hasil_kabupaten').text(text);
            $('#hasil_kecamatan').text("-");
            $('#hasil_kelurahan').text("-");

            $.ajax({

                url: "{{ route('wilayah.kecamatan') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },

                success: function (data) {

                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option>Pilih Kecamatan</option>');

                    $.each(data, function (key, val) {

                        $('#kecamatan').append(
                            '<option value="' + val.id + '">' + val.name + '</option>'
                        );

                    });

                }

            });

        });


        /* =======================
        KECAMATAN -> KELURAHAN
        ======================= */

        $('#kecamatan').change(function () {

            let id = $(this).val();
            let text = $("#kecamatan option:selected").text();

            $('#hasil_kecamatan').text(text);
            $('#hasil_kelurahan').text("-");

            $.ajax({

                url: "{{ route('wilayah.kelurahan') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },

                success: function (data) {

                    $('#kelurahan').empty();
                    $('#kelurahan').append('<option>Pilih Kelurahan</option>');

                    $.each(data, function (key, val) {

                        $('#kelurahan').append(
                            '<option value="' + val.id + '">' + val.name + '</option>'
                        );

                    });

                }

            });

        });


        /* =======================
        KELURAHAN -> TAMPILKAN HASIL
        ======================= */

        $('#kelurahan').change(function () {

            let text = $("#kelurahan option:selected").text();

            $('#hasil_kelurahan').text(text);

        });

    });

</script>