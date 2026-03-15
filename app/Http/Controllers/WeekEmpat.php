<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeekEmpat extends Controller
{
    public function index()
    {
        return view('week4.index');
    }

    public function submit(Request $req)
    {
        $name = $req->post('name');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data received successfully',
            'data' => [
                'name' => $name
            ]
        ]);
    }
}