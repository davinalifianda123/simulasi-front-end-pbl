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
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/barangs');

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
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/barangs/create');

        $categories = [];
        $satuan_berats = [];

        if ($response->successful()) {
            $data = $response->json('data');
            $categories = $data['categories'] ?? [];
            $satuan_berats = $data['satuanBerat'] ?? [];
        }

        return view('barangs.create', [
            'categories' => $categories,
            'satuan_berats' => $satuan_berats,
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
        $response = Http::withToken($token)->post('https://gudangku.web.id/api/barangs', $request->all());

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
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/barangs/{$id}");

        $barang = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $barang = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('barangs.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'barang' => $barang,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->get("https://gudangku.web.id/api/barangs/{$id}/edit");

        $result = json_decode($response->body());
        $data = $result->data;

        $nama_user = request()->attributes->get('nama_user');
        $nama_role = request()->attributes->get('nama_role');

        return view('barangs.edit', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'barang' => $data->barang ?? null,
            'kategoriBarang' => $data->categories ?? [],
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/barangs/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('barangs.index')->with('success', 'Barang berhasil diperbarui.');
        } else {
            $result = json_decode($response->body());
            return back()->withInput()->withErrors(['message' => $result->message ?? 'Gagal memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deactivate(string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/barangs/{$id}/deactivate");

        if ($response->successful()) {
            $message = $response->json('message');
            return redirect()->route('barangs.index')->with('success', $message);
        } else {
            $message = $response->json('message') ?? 'Gagal menonaktifkan barang.';
            return redirect()->route('barangs.index')->with('error', $message);
        }
    }
}
