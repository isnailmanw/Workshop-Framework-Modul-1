<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{

    /* =========================
       HALAMAN CASCADING AJAX
    ========================== */

    public function ajaxPage()
    {
        $provinsi = DB::table('reg_provinces')->get();

        return view('wilayah_ajax.index', compact('provinsi'));
    }



    /* =========================
       HALAMAN CASCADING AXIOS
    ========================== */

    public function axiosPage()
    {
        $provinsi = DB::table('reg_provinces')->get();

        return view('wilayah_axios.index', compact('provinsi'));
    }



    /* =========================
       API KABUPATEN
    ========================== */

    public function getKabupaten(Request $request)
    {
        $kabupaten = DB::table('reg_regencies')
            ->where('province_id', $request->id)
            ->get();

        return response()->json($kabupaten);
    }



    /* =========================
       API KECAMATAN
    ========================== */

    public function getKecamatan(Request $request)
    {
        $kecamatan = DB::table('reg_districts')
            ->where('regency_id', $request->id)
            ->get();

        return response()->json($kecamatan);
    }



    /* =========================
       API KELURAHAN
    ========================== */

    public function getKelurahan(Request $request)
    {
        $kelurahan = DB::table('reg_villages')
            ->where('district_id', $request->id)
            ->get();

        return response()->json($kelurahan);
    }

}