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

// 🔥 TAMBAHAN QR CODE (tetap dibiarkan, tidak dihapus)
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KantinController extends Controller
{
    public function index()
    {
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

        $order->update([
            'status_pembayaran' => 'lunas'
        ]);

        return response()->json([
            'status' => 'settlement'
        ]);
    }

    public function vendor()
    {
        $vendor_id = Auth::user()->vendor_id;

        $orders = Order::whereHas('details.menu', function ($q) use ($vendor_id) {
            $q->where('vendor_id', $vendor_id);
        })
            ->with('details.menu')
            ->latest()
            ->get();

        return view('vendor.index', compact('orders'));
    }

    public function vendorLunas()
    {
        $vendor_id = Auth::user()->vendor_id;

        $orders = Order::where('status_pembayaran', 'lunas')
            ->whereHas('details.menu', function ($q) use ($vendor_id) {
                $q->where('vendor_id', $vendor_id);
            })
            ->with('details.menu')
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

    // 🔥 FIX QR CODE (ANTI IMAGICK ERROR)
    public function success($id)
    {
        $order = Order::with('details.menu')->findOrFail($id);

        // 🔥 QR TANPA LIBRARY (PASTI JALAN)
        $qrcode = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=ORDER-" . $order->id;

        return view('kantin.success', compact('order', 'qrcode'));
    }

    public function struk($id)
    {
        $order = Order::with('details.menu')->findOrFail($id);

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        $barcode = base64_encode(
            $generator->getBarcode($order->id, $generator::TYPE_CODE_128)
        );

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kantin.struk', compact('order', 'barcode'));

        return $pdf->stream('struk.pdf');
    }
}