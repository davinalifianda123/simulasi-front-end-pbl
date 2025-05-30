<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->cookie('jwt_token');

        // Jalankan kedua request secara asynchronous
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('cards')->withToken($token)->get('http://localhost:8001/api/dashboard'),
            $pool->as('lowStock')->withToken($token)->post('http://localhost:8001/api/dashboard-low-stock'),
        ]);

        // Ambil hasil respons
        $dashboard = [];
        $lowStock = [];

        if ($responses['cards']->ok()) {
            $dashboardData = json_decode($responses['cards']->body());
            $dashboard = $dashboardData->data ?? [];
        }

        if ($responses['lowStock']->ok()) {
            $lowStockData = json_decode($responses['lowStock']->body());
            $lowStock = $lowStockData->data ?? [];
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('dashboard.index', compact('nama_user', 'nama_role', 'dashboard', 'lowStock'));
    }

    public function dashboardGraph(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $url = "http://localhost:8001/api/dashboard-graph";
        $res = Http::withToken($token)->post($url, [
          'filter_durasi' => $request->input('filter_durasi'),
        ]);

        return response()->json($res->body());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
