<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;

class MenuController extends Controller
{
    public function create()
    {
        $vendor = \App\Models\Vendor::where('user_id', auth()->id())->first();

        if (!$vendor) {
            return back()->with('error', 'Vendor tidak ditemukan');
        }

        $menus = \App\Models\Menu::where('vendor_id', $vendor->id)->get();

        return view('vendor.tambah_menu', compact('menus'));
    }


    public function store(Request $request)
    {
        // 🔥 ambil vendor berdasarkan user login
        $vendor = Vendor::where('user_id', auth()->id())->first();

        // 🔥 VALIDASI PENTING (TARUH DI SINI)
        if (!$vendor) {
            return back()->with('error', 'Vendor tidak ditemukan');
        }

        // 🔥 simpan menu
        Menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'vendor_id' => $vendor->id
        ]);

        return redirect('/menu/create')->with('success', 'Menu berhasil ditambahkan');
    }

    public function destroy($id)
    {
        Menu::find($id)->delete();
        return back();
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $menus = Menu::where('vendor_id', auth()->id())->get();

        return view('vendor.tambah_menu', compact('menu', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga
        ]);

        return redirect('/menu/create');
    }


}