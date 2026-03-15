@extends('layouts.master')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Demo AJAX</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <label>Name</label>
                <input type="text" id="myIdname" class="form-control">
            </div>

            <button class="btn btn-primary" onclick="submitText()">
                Submit
            </button>

            <hr>

            <h5>Output :</h5>
            <span id="freetext"></span>

        </div>
    </div>

@endsection

@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        function submitText() {

            var name = $('#myIdname').val();

            $.ajax({

                url: "{{ route('ajax.submit') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    name: name
                },

                success: function (response) {

                    console.log(response);

                    if (response.status == "success") {

                        $('#freetext').html(response.data.name);

                        Swal.fire(
                            'Success',
                            'Data berhasil dikirim',
                            'success'
                        );

                    }

                },

                error: function () {

                    Swal.fire(
                        'Error',
                        'Terjadi kesalahan',
                        'error'
                    );

                }

            });

        }

    </script>

@endsection