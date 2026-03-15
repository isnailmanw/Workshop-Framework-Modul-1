@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Cascading Select Wilayah (Axios)</h3>
    </div>

    <div class="card">
        <div class="card-body">

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
                    <label>Kabupaten</label>

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

@endsection



@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {

            const provinsi = document.getElementById('provinsi');
            const kabupaten = document.getElementById('kabupaten');
            const kecamatan = document.getElementById('kecamatan');
            const kelurahan = document.getElementById('kelurahan');


            /* ==========================
               PROVINSI → KABUPATEN
            ========================== */

            provinsi.addEventListener('change', function () {

                let id = this.value;

                let text = this.options[this.selectedIndex].text;
                document.getElementById('hasil_provinsi').innerText = text;
                document.getElementById('hasil_kabupaten').innerText = "-";
                document.getElementById('hasil_kecamatan').innerText = "-";
                document.getElementById('hasil_kelurahan').innerText = "-";

                kabupaten.innerHTML = '<option>Loading...</option>';
                kecamatan.innerHTML = '<option>Pilih Kecamatan</option>';
                kelurahan.innerHTML = '<option>Pilih Kelurahan</option>';

                axios.post("{{ route('wilayah.kabupaten') }}", {
                    _token: "{{ csrf_token() }}",
                    id: id
                })

                    .then(function (response) {

                        let data = response.data;

                        kabupaten.innerHTML = '<option value="">Pilih Kabupaten</option>';

                        data.forEach(function (item) {

                            kabupaten.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;

                        });

                    })

                    .catch(function (error) {
                        console.log(error);
                    });

            });



            /* ==========================
               KABUPATEN → KECAMATAN
            ========================== */

            kabupaten.addEventListener('change', function () {

                let id = this.value;

                let text = this.options[this.selectedIndex].text;
                document.getElementById('hasil_kabupaten').innerText = text;
                document.getElementById('hasil_kecamatan').innerText = "-";
                document.getElementById('hasil_kelurahan').innerText = "-";

                kecamatan.innerHTML = '<option>Loading...</option>';
                kelurahan.innerHTML = '<option>Pilih Kelurahan</option>';

                axios.post("{{ route('wilayah.kecamatan') }}", {
                    _token: "{{ csrf_token() }}",
                    id: id
                })

                    .then(function (response) {

                        let data = response.data;

                        kecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';

                        data.forEach(function (item) {

                            kecamatan.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;

                        });

                    });

            });



            /* ==========================
               KECAMATAN → KELURAHAN
            ========================== */

            kecamatan.addEventListener('change', function () {

                let id = this.value;

                let text = this.options[this.selectedIndex].text;
                document.getElementById('hasil_kecamatan').innerText = text;
                document.getElementById('hasil_kelurahan').innerText = "-";

                kelurahan.innerHTML = '<option>Loading...</option>';

                axios.post("{{ route('wilayah.kelurahan') }}", {
                    _token: "{{ csrf_token() }}",
                    id: id
                })

                    .then(function (response) {

                        let data = response.data;

                        kelurahan.innerHTML = '<option value="">Pilih Kelurahan</option>';

                        data.forEach(function (item) {

                            kelurahan.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;

                        });

                    });

            });



            /* ==========================
               KELURAHAN → TAMPILKAN HASIL
            ========================== */

            kelurahan.addEventListener('change', function () {

                let text = this.options[this.selectedIndex].text;

                document.getElementById('hasil_kelurahan').innerText = text;

            });


        });

    </script>

@endsection