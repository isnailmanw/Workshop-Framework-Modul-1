@extends('layouts.master')

@section('content')

    <div class="content-wrapper">

        <div class="row justify-content-center">

            <div class="col-lg-8 grid-margin stretch-card">

                <div class="card shadow-sm border-0 rounded-4">

                    <div class="card-body">

                        <!-- HEADER -->
                        <div class="mb-4">

                            <h2 class="font-weight-bold text-dark mb-1">
                                Tambah Toko
                            </h2>

                            <p class="text-muted mb-0">
                                Tambahkan lokasi toko untuk validasi kunjungan sales
                            </p>

                        </div>

                        <!-- FORM -->
                        <form action="/tambah-toko" method="POST">

                            @csrf

                            <!-- BARCODE -->
                            <div class="form-group">

                                <label>
                                    Barcode
                                </label>

                                <input type="text" name="barcode" class="form-control" placeholder="Masukkan barcode toko"
                                    required>

                            </div>

                            <!-- NAMA TOKO -->
                            <div class="form-group">

                                <label>
                                    Nama Toko
                                </label>

                                <input type="text" name="nama_toko" class="form-control" placeholder="Masukkan nama toko"
                                    required>

                            </div>

                            <!-- BUTTON GPS -->
                            <div class="form-group">

                                <button type="button" id="btn-lokasi" class="btn btn-gradient-primary btn-fw"
                                    onclick="ambilLokasi()">

                                    <i class="mdi mdi-crosshairs-gps"></i>

                                    Ambil Lokasi

                                </button>

                            </div>

                            <!-- LATITUDE -->
                            <div class="form-group">

                                <label>
                                    Latitude
                                </label>

                                <input type="text" id="latitude" name="latitude" class="form-control" readonly required>

                            </div>

                            <!-- LONGITUDE -->
                            <div class="form-group">

                                <label>
                                    Longitude
                                </label>

                                <input type="text" id="longitude" name="longitude" class="form-control" readonly required>

                            </div>

                            <!-- ACCURACY -->
                            <div class="form-group">

                                <label>
                                    Accuracy
                                </label>

                                <input type="text" id="accuracy" name="accuracy" class="form-control" readonly required>

                            </div>

                            <!-- BUTTON -->
                            <div class="mt-4">

                                <button type="submit" class="btn btn-gradient-success btn-fw">

                                    Simpan Toko

                                </button>

                                <a href="/kunjungan-toko" class="btn btn-light btn-fw">

                                    Kembali

                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@section('scripts')

    <script>

        async function ambilLokasi() {
            const tombol = document.querySelector('#btn-lokasi');

            tombol.innerHTML =
                '<i class="mdi mdi-loading mdi-spin"></i> Mengambil Lokasi...';

            tombol.disabled = true;

            try {
                const position = await getAccuratePosition(30);

                document.getElementById('latitude').value =
                    position.coords.latitude;

                document.getElementById('longitude').value =
                    position.coords.longitude;

                document.getElementById('accuracy').value =
                    Math.round(position.coords.accuracy);

                tombol.innerHTML =
                    '<i class="mdi mdi-check-circle"></i> Lokasi Berhasil';

            }
            catch (error) {
                alert('Gagal mengambil lokasi');

                tombol.innerHTML =
                    '<i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi';

                tombol.disabled = false;
            }
        }


        function getAccuratePosition(targetAccuracy = 30, maxWait = 20000) {
            return new Promise((resolve, reject) => {
                let bestResult = null;

                const startTime = Date.now();

                const watchId = navigator.geolocation.watchPosition(

                    (position) => {
                        const acc = position.coords.accuracy;

                        if (!bestResult || acc < bestResult.coords.accuracy) {
                            bestResult = position;
                        }

                        if (acc <= targetAccuracy) {
                            navigator.geolocation.clearWatch(watchId);

                            resolve(bestResult);
                        }

                        if (Date.now() - startTime >= maxWait) {
                            navigator.geolocation.clearWatch(watchId);

                            if (bestResult) {
                                resolve(bestResult);
                            }
                            else {
                                reject(new Error('Timeout'));
                            }
                        }
                    },

                    (error) => reject(error),

                    {
                        enableHighAccuracy: true,
                        maximumAge: 0,
                        timeout: maxWait
                    }

                );
            });
        }

    </script>

@endsection