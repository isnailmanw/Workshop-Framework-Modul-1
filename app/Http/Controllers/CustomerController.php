<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // 🔥 TAMPIL DATA
    public function index()
    {
        $data = Customer::orderBy('id', 'desc')->get();
        return view('customer.index', compact('data'));
    }

    // 🔥 FORM BLOB (KAMERA)
    public function create1()
    {
        return view('customer.create_blob');
    }

    // 🔥 FORM FILE (UPLOAD)
    public function create2()
    {
        return view('customer.create_file');
    }

    // 🔥 SIMPAN BLOB (KAMERA)
    public function storeBlob(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto_blob' => 'required'
        ]);

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_blob' => $request->foto_blob
        ]);

        return redirect('/customer')->with('success', 'Data berhasil disimpan!');
    }

    // 🔥 SIMPAN FILE (UPLOAD)
    public function storeFile(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'alamat' => 'nullable',
            'provinsi' => 'nullable',
            'kota' => 'nullable',
            'kecamatan' => 'nullable',
            'kodepos' => 'nullable'
        ]);

        $path = $request->file('foto')->store('customer', 'public');

        Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_path' => $path
        ]);

        return redirect('/customer')->with('success', 'Data berhasil disimpan!');
    }

    // 🔥 FORM EDIT
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    // 🔥 UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
        ]);

        return redirect('/customer')->with('success', 'Data berhasil diupdate');
    }
    // 🔥 DELETE (FIX BEST PRACTICE)
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        // 🔥 HAPUS FILE JIKA ADA
        if ($customer->foto_path && Storage::disk('public')->exists($customer->foto_path)) {
            Storage::disk('public')->delete($customer->foto_path);
        }

        $customer->delete();

        return redirect('/customer')->with('success', 'Data berhasil dihapus');
    }
}