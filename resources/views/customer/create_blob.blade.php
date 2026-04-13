@extends('layouts.master')

@section('content')

    <div class="container-fluid">

        <!-- HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark">📸 Tambah Customer (Kamera)</h3>
            <p class="text-muted">Ambil foto langsung dari kamera & lengkapi data customer</p>
        </div>

        <!-- CARD -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">

                <form method="POST" action="/customer/store1" onsubmit="return validateForm()">
                    @csrf

                    <div class="row">

                        <!-- FORM -->
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kota</label>
                                <input type="text" name="kota" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kodepos</label>
                                <input type="text" name="kodepos" class="form-control">
                            </div>

                        </div>

                        <!-- CAMERA -->
                        <div class="col-md-6 text-center">

                            <label class="form-label fw-semibold">Kamera</label>

                            <div class="border rounded-3 p-2 mb-3 bg-light">
                                <video id="video" class="w-100 rounded" autoplay playsinline></video>
                            </div>

                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <button type="button" class="btn btn-primary" onclick="startCamera()">
                                    🎥 Aktifkan
                                </button>

                                <button type="button" class="btn btn-success" onclick="takePhoto()">
                                    📸 Ambil
                                </button>
                            </div>

                            <!-- PREVIEW -->
                            <img id="preview" class="rounded shadow-sm" style="display:none; width:200px;">

                            <!-- HIDDEN -->
                            <canvas id="canvas" style="display:none;"></canvas>
                            <input type="hidden" name="foto_blob" id="foto">

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            💾 Simpan Customer
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection


@section('scripts')
    <script>

        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let fotoInput = document.getElementById('foto');
        let preview = document.getElementById('preview');
        let stream = null;

        // AKTIFKAN KAMERA
        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (err) {
                alert("❌ Kamera tidak bisa diakses! Pastikan izin browser aktif");
                console.log(err);
            }
        }

        // AMBIL FOTO
        function takePhoto() {

            if (!video.srcObject) {
                alert("Aktifkan kamera dulu!");
                return;
            }

            let context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            context.drawImage(video, 0, 0);

            let data = canvas.toDataURL('image/png');

            fotoInput.value = data;

            preview.src = data;
            preview.style.display = "block";
        }

        // VALIDASI SEBELUM SUBMIT
        function validateForm() {

            if (!fotoInput.value) {
                alert("❌ Ambil foto dulu sebelum simpan!");
                return false;
            }

            return true;
        }

    </script>
@endsection