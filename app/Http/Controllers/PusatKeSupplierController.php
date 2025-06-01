<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PusatKeSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/pusat-ke-suppliers');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('retur_barang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'pusatKeSuppliers' => $result->pusatKeSuppliers ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('http://localhost:8001/api/pusat-ke-suppliers/create');

        $data = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $data = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');
        $id_lokasi = $request->attributes->get('id_lokasi');

        return view('retur_barang.create', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'barangs' => $data->barangs ?? [],
            'suppliers' => $data->supplier ?? [],
            'satuanBerats' => $data->satuanBerat ?? [],
            'kurirs' => $data->kurir ?? [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string',
            'id_supplier' => 'required',
            'id_barang' => 'required',
            'jumlah_barang' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'id_satuan_berat' => 'required',
            'id_kurir' => 'required',
            'berat_satuan_barang' => 'required|numeric|min:1',
        ]);

        try {
            $token = $request->cookie('jwt_token');
            $response = Http::withToken($token)->post('http://localhost:8001/api/pusat-ke-suppliers', $validated);

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('pusat-ke-suppliers.index')->with('success', $result->message);
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
