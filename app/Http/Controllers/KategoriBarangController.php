<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/kategori-barangs');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('categories.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'kategoriBarangs' => $result->kategoriBarangs ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create', [
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
        $response = Http::withToken($token)->post('https://gudangku.web.id/api/kategori-barangs', [
            'nama_kategori_barang' => $request->input('nama_kategori_barang'),
        ]);

        if ($response->successful()) {
            return redirect()->route('kategori-barangs.index')->with('success', 'Kategori barang berhasil ditambahkan!');
        } elseif ($response->status() === 422) {
            $errorMessage = $response->json()['error'] ?? 'Terjadi kesalahan validasi.';
            return back()->withErrors([
                'nama_kategori_barang' => $errorMessage
            ])->withInput();


        } else {
            return back()->with('error', 'Gagal menambahkan kategori. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/kategori-barangs/{$id}");

        $kategoriBarang = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $kategoriBarang = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('categories.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'kategoriBarang' => $kategoriBarang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/kategori-barangs/{$id}/edit");

        if (!$response->successful()) {
            abort($response->status(), 'Gagal mengambil data kategori barang');
        }

        $result = json_decode($response->body());

        $nama_user = request()->attributes->get('nama_user');
        $nama_role = request()->attributes->get('nama_role');

        return view('categories.edit', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'kategoriBarang' => $result->data ?? null,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/kategori-barangs/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('kategori-barangs.index')->with('success', 'Kategori barang berhasil diperbarui.');
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/kategori-barangs/{$id}/deactivate");

        if ($response->successful()) {
            $message = $response->json('message');
            return redirect()->route('kategori-barangs.index')->with('success', $message);
        } else {
            $message = $response->json('message') ?? 'Gagal menonaktifkan kategori barang.';
            return redirect()->route('kategori-barangs.index')->with('error', $message);
        }
    }
}
