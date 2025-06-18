<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Str;

class PenerimaanDiPusatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/penerimaan-di-pusats');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('penerimaan_barang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'penerimaanDiPusats' => $result->penerimaanDiPusats ?? [],
            'headings' => $result->headings ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/penerimaan-di-pusats/create');

        $data = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $data = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');
        $id_lokasi = $request->attributes->get('id_lokasi');
        $lokasi = $request->attributes->get('lokasi');

        return view('penerimaan_barang.create', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'lokasi' => $lokasi ?? '',
            'barangs' => $data->barangs ?? [],
            'jenisPenerimaans' => $data->jenisPenerimaan ?? [],
            'satuanBerats' => $data->satuanBerat ?? [],
            'asalBarangs' => $data->asalBarang ?? [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $token = $request->cookie('jwt_token');
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/penerimaan-di-pusats', $request->all());

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('penerimaan-di-pusats.index')->with('success', $result->message);
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
    private function getPenerimaanDiPusatById($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/penerimaan-di-pusats/{$id}");

        if ($response->successful()) {
            $result = json_decode($response->body());
            return $result->data ?? null;
        }

        return null;
    }

    public function show(Request $request, string $id)
    {
        $penerimaanDiPusat = $this->getPenerimaanDiPusatById($id);

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('penerimaan_barang.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'penerimaanDiPusat' => $penerimaanDiPusat,
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/penerimaan-di-pusats/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('penerimaan-di-pusats.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('penerimaan-di-pusats.index')
                            ->with('error', $error);
        }
    }

    public function downloadInvoice($id)
    {
        $data = $this->getPenerimaanDiPusatById($id);
        $token = request()->cookie('jwt_token');
        $nama_user = request()->attributes->get('nama_user');

        // 🔄 Ambil daftar gudang dengan id=1
        $gudangResponse = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs/1');
        $responseJson = json_decode($gudangResponse->body());
        $gudangData = $responseJson->data ?? [];
       

        $allgudangResponse = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs');
        $allresponseJson = json_decode($allgudangResponse->body());
        $allgudangData = $allresponseJson->data->gudangs ?? [];


        // 🔄 Ambil daftar supplier


        // 🔍 Cari supplier yang cocok dengan asal_barang
        $mathedGudang = collect($allgudangData)->first(function ($gudang) use ($data) {
            return trim(strtolower($gudang->nama_gudang)) === trim(strtolower($data->asal_barang));
        });
        

        $buyer = new Buyer([
            'name' => $nama_user ?? 'Pusat Tidak Diketahui',
            'custom_fields' => [
                'Gudang' => $gudangData->nama_gudang ?? '-',
                'Alamat' => $gudangData->alamat ?? '-',
                'Telepon' => $gudangData->no_telepon ?? '-',
                'Tanggal Penerimaan' => $data->tanggal ?? '-',
            ],
        ]);

        $seller = new Buyer([
            'name' => $mathedGudang->nama_gudang_toko ?? $data->asal_barang ?? 'Supplier Tidak Diketahui',
            'custom_fields' => [
                'Alamat' => $mathedGudang->alamat ?? '-',
                'Telepon' => $mathedGudang->no_telepon ?? '-',
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
            ->filename('Invoice-Penerimaan-Pusat-' . Str::slug($data->id ?? 'no-id'))
            ->addItem($item)
            ->logo(public_path('images/Logo-invoice.png'));

        return $invoice->stream(); // atau ->download()
    }
}
