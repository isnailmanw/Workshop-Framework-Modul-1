<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TagHarga;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

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
            'nama' => $request->nama_barang, // 🔥 mapping ke field DB
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
        TagHarga::where('id', $id)
            ->update([
                'nama' => $request->nama_barang, // 🔥 fix
                'harga' => $request->harga
            ]);

        return redirect('/tagharga');
    }

    public function delete($id)
    {
        TagHarga::where('id', $id)->delete();
        return redirect('/tagharga');
    }

    public function cetak(Request $request)
    {
        // 🔥 AMANKAN kalau tidak ada yang dipilih
        if (!$request->has('pilih')) {
            return back()->with('error', 'Pilih data terlebih dahulu');
        }

        // 🔥 AMBIL DATA BERDASARKAN ID
        $data = TagHarga::whereIn('id', $request->pilih)->get();

        // 🔥 GENERATE BARCODE

        $generator = new BarcodeGeneratorPNG();

        foreach ($data as $d) {
            $d->barcode = base64_encode(
                $generator->getBarcode($d->kode, $generator::TYPE_CODE_128)
            );
        }

        // 🔥 FIX PENTING: CAST KE INTEGER
        $x = (int) $request->x;
        $y = (int) $request->y;

        // 🔥 VALIDASI MINIMAL
        if ($x < 1)
            $x = 1;
        if ($y < 1)
            $y = 1;

        /*
        Hitung posisi label
        */
        $posisi = ($y - 1) * 5 + $x;
        $kosong = $posisi - 1;

        // 🔥 DEBUG (kalau mau cek, aktifkan sementara)
        // dd($x, $y, $posisi, $kosong);

        // 🔥 GENERATE PDF
        $pdf = Pdf::loadView(
            'tagharga.pdf',
            compact('data', 'kosong')
        );

        return $pdf->download('tagharga.pdf');
    }
}