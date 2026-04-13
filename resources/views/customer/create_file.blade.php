@extends('layouts.master')

@section('content')

    <div class="container-fluid">

        <!-- 🔥 HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold text-dark">🖼 Tambah Customer (Upload File)</h3>
            <p class="text-muted">Upload foto dari perangkat & lengkapi data customer</p>
        </div>

        <!-- 🔥 CARD -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">

                <form method="POST" action="/customer/store2" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- 🔥 FORM DATA -->
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control" placeholder="Provinsi">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kota</label>
                                <input type="text" name="kota" class="form-control" placeholder="Kota">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kodepos</label>
                                <input type="text" name="kodepos" class="form-control" placeholder="Kodepos">
                            </div>

                        </div>

                        <!-- 🔥 UPLOAD FOTO -->
                        <div class="col-md-6 text-center">

                            <label class="form-label fw-semibold">Upload Foto</label>

                            <div class="border rounded-3 p-4 bg-light mb-3">

                                <input type="file" name="foto" id="fotoInput" class="form-control mb-3" accept="image/*"
                                    required>

                                <!-- 🔥 PREVIEW -->
                                <img id="preview" src="" class="rounded shadow-sm"
                                    style="display:none; width:200px; object-fit:cover;">
                            </div>

                        </div>

                    </div>

                    <!-- 🔥 BUTTON -->
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success px-4">
                            💾 Simpan Customer
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection


@push('scripts')
    <script>
        let input = document.getElementById('fotoInput');
        let preview = document.getElementById('preview');

        input.addEventListener('change', function () {
            let file = this.files[0];

            if (file) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush