<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('role');

        return view('gudangs.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'gudangs' => $result->gudangs ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gudangs.create', [
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
        $response = Http::withToken($token)->post('https://gudangku.web.id/api/gudangs', [
            'nama_gudang_toko' => $request->input('nama_gudang_toko'),
            'alamat' => $request->input('alamat'),
            'no_telepon' => $request->input('no_telepon'),
        ]);

        if ($response->successful()) {
            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil ditambahkan!');
        } elseif ($response->status() === 422) {
            $errors = $response->json()['errors'] ?? [];
            return back()->withErrors($errors)->withInput();
        } else {
            return back()->with('error', 'Gagal menambahkan gudang. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/gudangs/{$id}");

        $gudang = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $gudang = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('gudangs.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'gudang' => $gudang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/gudangs/{$id}/edit");

        if (!$response->successful()) {
            abort($response->status(), 'Gagal mengambil data gudang');
        }

        $result = json_decode($response->body());

        $nama_user = request()->attributes->get('nama_user');
        $nama_role = request()->attributes->get('nama_role');

        return view('gudangs.edit', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'gudang' => $result->data ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/gudangs/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('gudangs.index')->with('success', 'Gudang berhasil diperbarui.');
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

    /**
     * Toggle the status of the specified gudang.
     */
    public function toggle(string $id, Request $request)
    {
        $token = request()->cookie('jwt_token');

        // Pertama, cek status gudang saat ini
        $check = Http::withToken($token)->get("https://gudangku.web.id/api/gudangs/{$id}");

        $gudang = null;
        if ($check->successful()) {
            $result = json_decode($check->body());
            $gudang = $result->data ?? null;
        }

        // Tentukan endpoint yang akan dipanggil
        $endpoint = $gudang->status == 'Aktif'
            ? "https://gudangku.web.id/api/gudangs/{$id}/deactivate"
            : "https://gudangku.web.id/api/gudangs/{$id}/activate";

        $response = Http::withToken($token)->patch($endpoint);

        if ($response->successful()) {
            $message = $response->json('message') ?? 'Berhasil mengubah status opname.';
            return redirect()->route('gudangs.index')->with('success', $message);
        }

        $errorMessage = $response->json('message') ?? 'Gagal mengubah status opname.';
        return redirect()->route('gudangs.index')->with('error', $errorMessage);
    }

}
