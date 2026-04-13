<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function create()
    {
        $vendors = \App\Models\Vendor::with('user')->get();
        return view('vendor.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // 🔥 1. BUAT USER LOGIN
        $user = User::create([
            'name' => $request->nama_vendor,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'vendor'
        ]);

        // 🔥 2. BUAT VENDOR
        $vendor = Vendor::create([
            'nama_vendor' => $request->nama_vendor
        ]);

        // 🔥 3. HUBUNGKAN USER KE VENDOR (INI YANG PENTING)
        $user->vendor_id = $vendor->id;
        $user->save();

        return redirect('/vendor/create')->with('success', 'Vendor berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);

        // hapus user juga
        if ($vendor->user) {
            $vendor->user->delete();
        }

        $vendor->delete();

        return back()->with('success', 'Vendor berhasil dihapus');
    }
}