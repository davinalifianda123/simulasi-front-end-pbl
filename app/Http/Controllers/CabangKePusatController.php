<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CabangKePusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/cabang-ke-pusats');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('retur_barang_cabang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'cabangKePusats' => $result->CabangKePusats ?? [],
            'statuses' => $result->statuses ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/cabang-ke-pusats/create');

        $data = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $data = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');
        $id_lokasi = $request->attributes->get('id_lokasi');

        return view('retur_barang_cabang.create', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'barangs' => $data->barangs ?? [],
            'cabangs' => $data->cabangs ?? [],
            'satuanBerats' => $data->satuanBerat ?? [],
            'kurirs' => $data->kurir ?? [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $token = $request->cookie('jwt_token');
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/cabang-ke-pusats', $request->all());

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('cabang-ke-pusats.index')->with('success', $result->message);
            } else {
                return back()->withErrors([
                    'api' => $result->message ?? 'Gagal menyimpan data.',
                ])->withInput();
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'exception' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/cabang-ke-pusats/{$id}");

        $cabangKePusat = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $cabangKePusat = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('retur_barang_cabang.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'cabangKePusat' => $cabangKePusat,
        ]);
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

    public function deactivate(string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/cabang-ke-pusats/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('cabang-ke-pusats.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('cabang-ke-pusats.index')
                            ->with('error', $error);
        }
    }

    public function updateStatus(string $id)
    {
        $token = request()->cookie('jwt_token');
        $payload = [
            'id_status' => request()->input('id_status'),
        ];

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/cabang-ke-pusats/{$id}", $payload);

        $responseBody = $response->json();

        $message = $responseBody['message'] ?? ($response->successful() ? 'Status berhasil diperbarui.' : 'Gagal memperbarui status.');

        return redirect()->route('cabang-ke-pusats.index')->with($response->successful() ? 'success' : 'error', $message);
    }
}
