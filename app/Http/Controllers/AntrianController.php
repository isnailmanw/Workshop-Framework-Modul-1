<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Poli;

class AntrianController extends Controller
{
    public function guest()
    {
        $poli = Poli::all();

        return view('antrian.guest', compact('poli'));
    }

    public function admin()
    {
        $antrian = Antrian::with('poli')
            ->orderBy('nomor_antrian', 'asc')
            ->get();

        $current = Antrian::where('status', 'called')
            ->latest()
            ->first();

        $waiting = Antrian::where('status', 'waiting')->count();

        $called = Antrian::where('status', 'called')->count();

        $done = Antrian::where('status', 'done')->count();

        $total = Antrian::count();

        return view('antrian.admin', compact(
            'antrian',
            'current',
            'waiting',
            'called',
            'done',
            'total'
        ));
    }

    public function papan()
    {
        $current = Antrian::with('poli')
            ->where('status', 'called')
            ->latest()
            ->first();

        $waitingList = Antrian::with('poli')
            ->where('status', 'waiting')
            ->orderBy('nomor_antrian', 'asc')
            ->get();

        return view('antrian.papan', compact(
            'current',
            'waitingList'
        ));
    }

    public function store(Request $request)
    {

        $request->validate([

            'nama_pengunjung' => 'required',

            'poli_id' => 'required'

        ]);

        // nomor terakhir
        $last = Antrian::latest()->first();

        $nomor = $last ? $last->nomor_antrian + 1 : 1;

        // simpan
        Antrian::create([

            'nomor_antrian' => $nomor,

            'nama_pengunjung' => $request->nama_pengunjung,

            'poli_id' => $request->poli_id,

            'status' => 'waiting'

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Berhasil ambil antrian'

        ]);

    }

    public function stream()
    {
        return response()->stream(function () {

            // disable semua buffering
            @ini_set('zlib.output_compression', 0);
            @ini_set('implicit_flush', 1);

            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            ob_implicit_flush(true);

            while (true) {

                if (connection_aborted()) {
                    break;
                }

                $current = Antrian::with('poli')
                    ->where('status', 'called')
                    ->latest('updated_at')
                    ->first();

                $queues = Antrian::with('poli')
                    ->orderBy('nomor_antrian', 'asc')
                    ->get();

                $data = [

                    'current' => $current,

                    'waiting' => Antrian::where('status', 'waiting')->count(),

                    'called' => Antrian::where('status', 'called')->count(),

                    'done' => Antrian::where('status', 'done')->count(),

                    'total' => Antrian::count(),

                    'queues' => $queues,

                    // paksa browser anggap data baru
                    'timestamp' => microtime(true)

                ];

                echo "event: update\n";
                echo "retry: 1000\n";
                echo "data: " . json_encode($data) . "\n\n";

                // INI PALING PENTING
                flush();

                usleep(200000); // 0.2 detik
            }

        }, 200, [

            'Content-Type' => 'text/event-stream',

            'Cache-Control' => 'no-cache',

            'Connection' => 'keep-alive',

            'X-Accel-Buffering' => 'no',

        ]);
    }

    public function panggil()
    {
        // ubah called sebelumnya jadi done
        Antrian::where('status', 'called')
            ->update([
                'status' => 'done'
            ]);


        // ambil waiting pertama
        $next = Antrian::where('status', 'waiting')
            ->orderBy('nomor_antrian', 'asc')
            ->first();


        // ubah jadi called
        if ($next) {

            $next->update([
                'status' => 'called'
            ]);

        }


        return response()->json([
            'success' => true
        ]);
    }

    public function panggilAntrian()
    {

        // ubah antrian sebelumnya
        Antrian::where('status', 'called')
            ->update([
                'status' => 'done'
            ]);

        // ambil waiting pertama
        $antrian = Antrian::where('status', 'waiting')
            ->orderBy('nomor_antrian')
            ->first();

        if ($antrian) {

            $antrian->update([
                'status' => 'called'
            ]);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);

    }

    public function reset()
    {
        Antrian::truncate();
        return response()->json(['success' => true]);
    }

    public function selesai($id)
    {
        Antrian::where('id', $id)->update(['status' => 'done']);
        return response()->json(['success' => true]);
    }

}