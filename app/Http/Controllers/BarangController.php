<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/barangs');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('barangs.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'barangs' => $result->barangs ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/barangs/create');

        $categories = [];

        if ($response->successful()) {
            $data = $response->json('data');
            $categories = $data['categories'] ?? [];
        }

        return view('barangs.create', [
            'categories' => $categories,
            'nama_user' => $request->attributes->get('nama_user', ''),
            'nama_role' => $request->attributes->get('nama_role', ''),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->post('http://localhost:8001/api/barangs', [
            'nama_barang' => $request->input('nama_barang'),
            'id_kategori_barang' => $request->input('id_kategori_barang'),
        ]);

        if ($response->successful()) {
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan!');
        } elseif ($response->status() === 422) {
            $errors = $response->json()['errors'] ?? [];
            return back()->withErrors($errors)->withInput();
        } else {
            return back()->with('error', 'Gagal menambahkan barang. Silakan coba lagi.');
        }
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
