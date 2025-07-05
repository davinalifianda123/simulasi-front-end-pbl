<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DetailGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/detail-gudangs');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('detail_gudang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'detailGudangs' => $result->detailGudangs ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/detail-gudangs/create');

        $responseDetailGudang = Http::withToken($token)->get('https://gudangku.web.id/api/detail-gudangs');

        $detailGudang = [];
        if ($responseDetailGudang->successful()) {
            $result = json_decode($responseDetailGudang->body());
            $detailGudang = $result->data;
        }

        $data = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $data = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $role = $request->attributes->get('nama_role');
        $id_lokasi = $request->attributes->get('id_lokasi');
        $lokasi = $request->attributes->get('lokasi');

        return view('detail_gudang.create', [
            'nama_user' => $nama_user ?? '',
            'role' => $role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'lokasi' => $lokasi ?? '',
            'barangs' => $data->barangs ?? [],
            'gudangs' => $data->gudang ?? [],
            'satuanBerats' => $data->satuanBerat ?? [],
            'detailGudangs' => $detailGudang->detailGudangs ?? [],
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $token = $request->cookie('jwt_token');
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/detail-gudangs', $request->all());

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('detail-gudangs.index')->with('success', $result->message);
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
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/detail-gudangs/{$id}");

        $detailGudang = null;
        if ($response->successful()) {
            $result = json_decode($response->body());
            $detailGudang = $result->data ?? null;
        }

        $nama_user = $request->attributes->get('nama_user');
        $role = $request->attributes->get('role');

        return view('detail_gudang.show', [
            'nama_user' => $nama_user ?? '',
            'role' => $role ?? '',
            'detailGudang' => $detailGudang,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->get("https://gudangku.web.id/api/detail-gudangs/{$id}/edit");
        $response2 = Http::withToken($token)->get('https://gudangku.web.id/api/detail-gudangs');

        $result2 = [];
        if ($response2->successful()) {
            $result2 = json_decode($response2->body());
            $result2 = $result2->data->detailGudangs ?? [];
        }

        $result = json_decode($response->body());
        $data = $result->data ?? [];
        
        $nama_user = request()->attributes->get('nama_user');
        $role = request()->attributes->get('role');
        $id_lokasi = request()->attributes->get('id_lokasi');

        return view('detail_gudang.edit', [
            'nama_user' => $nama_user ?? '',
            'role' => $role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'detailGudang' => $data->detailGudang,
            'barangs' => $data->barangs ?? [],
            'gudangs' => $data->gudang ?? [],
            'detailGudangs' => $result2,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/detail-gudangs/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('detail-gudangs.index')->with('success', 'Detail Gudang berhasil diperbarui.');
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/detail-gudangs/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('detail-gudangs.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('detail-gudangs.index')
                            ->with('error', $error);
        }
    }

}
