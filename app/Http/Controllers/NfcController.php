<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NfcController extends Controller
{
    public function save(Request $request)
    {
        DB::table('nfc_cards')->insert([
            'serial_number' => $request->serial_number,
            'nama' => 'Pemilik Kartu'
        ]);

        return response()->json([
            'message' => 'Data NFC berhasil disimpan'
        ]);
    }

    public function simpanAbsensi(Request $request)
    {
        DB::table('absensi')->insert([

            'serial_number' => $request->serial_number,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'waktu_scan' => now()

        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function riwayatAbsensi()
    {
        $absensis = DB::table('absensi')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'absensi.index',
            compact('absensis')
        );
    }
}