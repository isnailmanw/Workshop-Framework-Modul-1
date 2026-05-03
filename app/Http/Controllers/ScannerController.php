<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ScannerController extends Controller
{
    public function barang()
    {
        return view('scanner.barang');
    }

    public function getBarang($kode)
    {
        $barang = DB::table('barang')
            ->where('kode', $kode)
            ->first();

        return response()->json($barang);
    }

    public function show($kode)
    {
        $barang = DB::table('barang')
            ->where('kode', $kode)
            ->first();

        return view('scanner.hasil', compact('barang'));
    }
}