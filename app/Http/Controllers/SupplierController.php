<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/suppliers');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('suppliers.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'suppliers' => $result->suppliers ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create', [
            'nama_user' => request()->attributes->get('nama_user', ''),
            'nama_role' => request()->attributes->get('nama_role', ''),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->post('http://localhost:8001/api/suppliers', [
            'nama_gudang_toko' => $request->input('nama_gudang_toko'),
            'alamat' => $request->input('alamat'),
            'no_telepon' => $request->input('no_telepon'),
        ]);

        if ($response->successful()) {
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
        } elseif ($response->status() === 422) {
            $errors = $response->json()['errors'] ?? [];
            return back()->withErrors($errors)->withInput();
        } else {
            return back()->with('error', 'Gagal menambahkan supplier. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("http://localhost:8001/api/suppliers/{$id}");

        $supplier = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $supplier = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('suppliers.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("http://localhost:8001/api/suppliers/{$id}/edit");

        if (!$response->successful()) {
            abort($response->status(), 'Gagal mengambil data supplier');
        }

        $result = json_decode($response->body());

        $nama_user = request()->attributes->get('nama_user');
        $nama_role = request()->attributes->get('nama_role');

        return view('suppliers.edit', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'supplier' => $result->data ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("http://localhost:8001/api/suppliers/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
        } else {
            $result = json_decode($response->body());
            return back()->withInput()->withErrors(['message' => $result->message ?? 'Gagal memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
