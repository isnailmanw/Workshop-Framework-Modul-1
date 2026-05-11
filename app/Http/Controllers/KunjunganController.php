<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KunjunganController extends Controller
{
    public function index()
    {
        $toko = DB::table('toko')
            ->orderBy('id', 'desc')
            ->get();

        return view('kunjungan.index', compact('toko'));
    }

    public function create()
    {
        return view('kunjungan.create');
    }

    public function store(Request $request)
    {
        DB::table('toko')->insert([

            'barcode' => $request->barcode,
            'nama_toko' => $request->nama_toko,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,

        ]);

        return redirect('/kunjungan-toko')
            ->with('success', 'Data toko berhasil ditambahkan');
    }

    public function qrcode($id)
    {
        $toko = DB::table('toko')->where('id', $id)->first();

        return view('kunjungan.qrcode', compact('toko'));
    }

    public function scan()
    {
        return view('kunjungan.scan');
    }

    public function getToko($barcode)
    {
        $toko = DB::table('toko')
            ->where('barcode', $barcode)
            ->first();

        return response()->json($toko);
    }
}