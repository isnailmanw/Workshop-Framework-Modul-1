@extends('layouts.master')

@section('title', 'Kategori')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Data Kategori</h4>

            <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">
                + Tambah Data
            </a>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>
                                    <a href="{{ route('kategori.edit', $item->idkategori) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('kategori.destroy', $item->idkategori) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($data->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    Belum ada data
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection