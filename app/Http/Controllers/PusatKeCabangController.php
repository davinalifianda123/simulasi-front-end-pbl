<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Str;

class PusatKeCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/pusat-ke-cabangs');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('pengiriman_barang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'pusatKeCabangs' => $result->pusatKeCabangs ?? [],
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
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/pusat-ke-cabangs/create');

        $data = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $data = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');
        $id_lokasi = $request->attributes->get('id_lokasi');

        return view('pengiriman_barang.create', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'barangs' => $data->barangs ?? [],
            'cabangs' => $data->cabang ?? [],
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
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/pusat-ke-cabangs', $request->all());

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('pusat-ke-cabangs.index')->with('success', $result->message);
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
    private function getPusatKeCabangById($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/pusat-ke-cabangs/{$id}");

        if ($response->successful()) {
            $result = json_decode($response->body());
            return $result->data ?? null;
        }

        return null;
    }

    public function show(Request $request, string $id)
    {
        $pusatKeCabang = $this->getPusatKeCabangById($id);

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('pengiriman_barang.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'pusatKeCabang' => $pusatKeCabang,
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/pusat-ke-cabangs/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('pusat-ke-cabangs.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('pusat-ke-cabangs.index')
                            ->with('error', $error);
        }
    }

    public function updateStatus(string $id)
    {
        $token = request()->cookie('jwt_token');
        $payload = [
            'id_status' => request()->input('id_status'),
        ];

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/pusat-ke-cabangs/{$id}", $payload);

        $responseBody = $response->json();

        $message = $responseBody['message'] ?? ($response->successful() ? 'Status berhasil diperbarui.' : 'Gagal memperbarui status.');

        return redirect()->route('pusat-ke-cabangs.index')->with($response->successful() ? 'success' : 'error', $message);
    }

    public function downloadInvoice($id)
    {
        $data = $this->getPusatKeCabangById($id);
        $token = request()->cookie('jwt_token');
        $nama_user = request()->attributes->get('nama_user');

        // 🔄 Ambil daftar gudang
        $gudangResponse = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs');
        $responseJson = json_decode($gudangResponse->body());
        $gudangData = $responseJson->data->gudangs ?? [];

        // 🔍 Cari gudang yang cocok dengan nama_cabang
        $matchedGudangCabang = collect($gudangData)->first(function ($gudang) use ($data) {
            return trim(strtolower($gudang->nama_gudang)) === trim(strtolower($data->nama_cabang));
        });

        // 🔍 Cari gudang yang cocok dengan nama_pusat
        $matchedGudangPusat = collect($gudangData)->first(function ($gudang) use ($data) {
            return trim(strtolower($gudang->nama_gudang)) === trim(strtolower($data->nama_pusat));
        });
        

        $buyer = new Buyer([
            'name' => $nama_user ?? 'Pusat Tidak Diketahui',
            'custom_fields' => [
                'Gudang' => $matchedGudangCabang->nama_gudang ?? '-',
                'Alamat' => $matchedGudangCabang->alamat ?? '-',
                'Telepon' => $matchedGudangCabang->no_telepon ?? '-',
                'Tanggal Penerimaan' => $data->tanggal ?? '-',
            ],
        ]);

        $seller = new Buyer([
            'name' => $matchedGudangPusat->nama_gudang ?? $data->nama_pusat,
            'custom_fields' => [
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
            ->filename('Invoice-Pengiriman-Pusat-' . Str::slug($data->id ?? 'no-id'))
            ->addItem($item)
            ->logo(public_path('images/Logo-invoice.png'));

        return $invoice->stream(); // atau ->download()
    }

}
