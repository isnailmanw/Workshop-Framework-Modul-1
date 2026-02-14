@extends('layouts.master')

@section('title', 'Data Buku')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Data Buku</h4>

            <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
                Tambah Buku
            </a>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->pengarang }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>
                                <a href="{{ route('buku.edit', $item->idbuku) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('buku.destroy', $item->idbuku) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection