<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{

    public function index()
    {
        return view('pos.index');
    }


    public function getBarang(Request $request)
    {
        $kode = trim($request->kode);

        $barang = DB::table('barang')
            ->where('id_barang', $kode)
            ->first();

        return response()->json($barang);
    }

    public function simpan(Request $request)
    {

        $items = $request->items;
        $total = $request->total;

        $id_penjualan = DB::table('penjualan')->insertGetId(
            ['total' => $total],
            'id_penjualan'
        );

        foreach ($items as $item) {

            DB::table('penjualan_detail')->insert([
                'id_penjualan' => $id_penjualan,
                'id_barang' => $item['id_barang'],
                'jumlah' => $item['jumlah'],
                'subtotal' => $item['subtotal']
            ]);

        }

        return response()->json([
            'status' => 'ok'
        ]);

    }

    public function riwayat()
    {

        $data = DB::table('penjualan')
            ->orderBy('id_penjualan', 'desc')
            ->get();

        return view('penjualan.index', compact('data'));

    }

    public function detail($id)
    {

        $header = DB::table('penjualan')
            ->where('id_penjualan', $id)
            ->first();

        $detail = DB::table('penjualan_detail')
            ->join('barang', 'barang.id_barang', '=', 'penjualan_detail.id_barang')
            ->where('penjualan_detail.id_penjualan', $id)
            ->select(
                'barang.nama',
                'penjualan_detail.jumlah',
                'penjualan_detail.subtotal',
                'barang.harga'
            )
            ->get();

        return view('penjualan.detail', compact('header', 'detail'));

    }
}