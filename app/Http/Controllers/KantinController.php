<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Menu;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class KantinController extends Controller
{
    public function index()
    {
        // 🔥 paksa logout kalau ada user login
        if (Auth::check()) {
            Auth::logout();
        }

        $vendors = Vendor::all();

        return view('kantin.index', compact('vendors'));
    }


    public function checkout(Request $request)
    {
        $data = $request->json()->all();

        $items = $data['items'];
        $total = $data['total'];

        // 🔥 ambil order terakhir
        $lastOrder = Order::latest()->first();

        if ($lastOrder) {
            $lastNumber = (int) str_replace('Guest_', '', $lastOrder->nama_customer);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $guestName = 'Guest_' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        $order = Order::create([
            'nama_customer' => $guestName,
            'total' => $total,
            'status_pembayaran' => 'lunas'
        ]);

        foreach ($items as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'menu_id' => $item['menu_id'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal']
            ]);
        }

        return response()->json([
            'message' => 'Pesanan berhasil!',
            'order_id' => $order->id
        ]);
    }


    public function getMenu($vendor_id)
    {
        $menu = Menu::where('vendor_id', $vendor_id)->get();
        return response()->json($menu);
    }

    public function bayar(Request $request)
    {
        try {
            // logic kamu disini

            return response()->json([
                'success' => true,
                'message' => 'Berhasil bayar'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function bayarMidtrans($id)
    {
        $order = Order::findOrFail($id);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->nama_customer,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }

    public function callback(Request $request)
    {
        $order = Order::find($request->order_id);

        if ($request->transaction_status == 'settlement') {
            $order->update([
                'status_pembayaran' => 'lunas'
            ]);
        }

        return response()->json(['message' => 'ok']);
    }

    public function checkStatus($order_id)
    {
        $order = Order::find($order_id);

        // 🔥 paksa lunas (demo)
        $order->update([
            'status_pembayaran' => 'lunas'
        ]);

        return response()->json([
            'status' => 'settlement'
        ]);
    }

    public function vendor()
    {
        $orders = Order::with('details.menu')->latest()->get();
        return view('vendor.index', compact('orders'));
    }

    public function vendorLunas()
    {
        $orders = Order::with('details.menu')
            ->where('status_pembayaran', 'lunas')
            ->latest()
            ->get();

        return view('vendor.index', compact('orders'));
    }

    public function fakeSuccess($id)
    {
        $order = Order::where('id', $id)->first();

        if (!$order) {
            return response()->json(['message' => 'order not found']);
        }

        $order->status_pembayaran = 'lunas';
        $order->save();

        return response()->json([
            'message' => 'updated',
            'id' => $id
        ]);
    }
}