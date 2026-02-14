<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $data = Buku::with('kategori')->get();
        return view('buku.index', compact('data'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:buku,kode',
            'judul' => 'required',
            'pengarang' => 'required',
            'idkategori' => 'required'
        ], [
            'kode.unique' => 'Kode telah terpakai'
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }


    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|unique:buku,kode,' . $id . ',idbuku',
            'judul' => 'required',
            'pengarang' => 'required',
            'idkategori' => 'required'
        ], [
            'kode.unique' => 'Kode telah terpakai'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diupdate');
    }


    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}
