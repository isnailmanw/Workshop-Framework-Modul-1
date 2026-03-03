<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagHarga;
use Barryvdh\DomPDF\Facade\Pdf;

class TagHargaController extends Controller
{

    public function index()
    {
        $data = TagHarga::all();

        return view('tagharga.index', compact('data'));
    }

    public function create()
    {
        return view('tagharga.create');
    }

    public function store(Request $request)
    {
        TagHarga::create([
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga
        ]);

        return redirect('/tagharga');
    }

    public function edit($id)
    {
        $data = TagHarga::find($id);

        return view('tagharga.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        TagHarga::where('id_barang', $id)
            ->update([
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga
            ]);

        return redirect('/tagharga');
    }

    public function delete($id)
    {
        TagHarga::where('id_barang', $id)->delete();

        return redirect('/tagharga');
    }

    public function cetak(Request $request)
    {

        $data = TagHarga::whereIn(
            'id_barang',
            $request->pilih
        )->get();


        $x = $request->x;
        $y = $request->y;


        /*
        Hitung posisi label
        */

        $posisi = ($y - 1) * 5 + $x;

        $kosong = $posisi - 1;


        $pdf = Pdf::loadView(
            'tagharga.pdf',
            compact('data', 'kosong')
        );

        return $pdf->download('tagharga.pdf');

    }

}