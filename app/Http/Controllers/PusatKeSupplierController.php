<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Str;

class PusatKeSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/pusat-ke-suppliers');

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
            'statuses' => $result->statuses ?? [],
            'headings' => $result->headings ?? [],
            'status_opname' => $result->status_opname ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/pusat-ke-suppliers/create');
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
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/pusat-ke-suppliers', $request->all());

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
    private function getPusatKeSupplierById($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/pusat-ke-suppliers/{$id}");

        if ($response->successful()) {
            $result = json_decode($response->body());
            return $result->data ?? null;
        }

        return null;
    }

    public function show(Request $request, string $id)
    {
        $pusatKeSupplier = $this->getPusatKeSupplierById($id);

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('retur_barang.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'pusatKeSupplier' => $pusatKeSupplier,
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/pusat-ke-suppliers/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('pusat-ke-suppliers.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('pusat-ke-suppliers.index')
                            ->with('error', $error);
        }
    }

    public function updateStatus(string $id)
    {
        $token = request()->cookie('jwt_token');
        $payload = [
            'id_status' => request()->input('id_status'),
        ];

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/pusat-ke-suppliers/{$id}", $payload);

        $responseBody = $response->json();

        $message = $responseBody['message'] ?? ($response->successful() ? 'Status berhasil diperbarui.' : 'Gagal memperbarui status.');

        return redirect()->route('pusat-ke-suppliers.index')->with($response->successful() ? 'success' : 'error', $message);
    }

    public function downloadInvoice($id)
    {
        $data = $this->getPusatKeSupplierById($id);
        $token = request()->cookie('jwt_token');
        $nama_user = request()->attributes->get('nama_user');

        // 🔄 Ambil daftar gudang
        $gudangResponse = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs');
        $responseJson = json_decode($gudangResponse->body());
        $gudangData = $responseJson->data->gudangs ?? [];

        // 🔍 Cari gudang yang cocok dengan nama_pusat
        $matchedGudangPusat = collect($gudangData)->first(function ($gudang) use ($data) {
            return trim(strtolower($gudang->nama_gudang)) === trim(strtolower($data->nama_pusat));
        });

        // 🔄 Ambil daftar supplier
        $supplierResponse = Http::withToken($token)->get('https://gudangku.web.id/api/suppliers');
        $responseJson = json_decode($supplierResponse->body());
        $supplierData = $responseJson->data->suppliers ?? [];

        // 🔍 Cari supplier yang cocok dengan nama_supplier
        $matchedSupplier = collect($supplierData)->first(function ($supplier) use ($data) {
            return trim(strtolower($supplier->nama_gudang_toko)) === trim(strtolower($data->nama_supplier));
        });
        

        $buyer = new Buyer([
            'name' => $matchedSupplier->nama_gudang_toko ?? '-',
            'custom_fields' => [
                'Alamat' => $matchedSupplier->alamat ?? '-',
                'Telepon' => $matchedSupplier->no_telepon ?? '-',
                'Tanggal Penerimaan' => $data->tanggal ?? '-',
            ],
        ]);

        $seller = new Buyer([
            'name' => $nama_user,
            'custom_fields' => [
                'Gudang' => $matchedGudangPusat->nama_gudang ?? '-',
                'Alamat' => $matchedGudangPusat->alamat ?? '-',
                'Telepon' => $matchedGudangPusat->no_telepon ?? '-',
            ],
        ]);

        // 📦 Item
        $item = (new InvoiceItem())
            ->title($data->nama_barang ?? 'Barang Tidak Diketahui')
            ->description('Jenis Penerimaan: ' . ($data->jenis_penerimaan ?? '-') . ', Berat/Satuan: ' . ($data->berat_satuan_barang ?? '-') . ' kg')
            ->units($data->satuan_berat ?? '-')
            ->pricePerUnit(0)
            ->quantity($data->jumlah_barang ?? 1);

        // 🧾 Generate Invoice
        $invoice = Invoice::make()
            ->seller($seller)
            ->buyer($buyer)
            ->date(now())
            ->dateFormat('d/m/Y')
            ->currencySymbol('Rp ')
            ->currencyCode('IDR')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->filename('Invoice-Retur-Pusat-' . Str::slug($data->id ?? 'no-id'))
            ->addItem($item)
            ->logo(public_path('images/Logo-invoice.png'));

        return $invoice->stream(); // atau ->download()
    }
}
