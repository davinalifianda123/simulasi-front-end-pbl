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
            'status_opname' => $result->status_opname ?? [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $token = $request->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/penerimaan-di-pusats/create');
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
    public function update(Request $request, $id)
    {
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/penerimaan-di-pusats/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('penerimaan-di-pusats.index')->with('success', 'Status penerimaan berhasil diperbarui.');
        } else {
            $result = json_decode($response->body());
            return redirect()->back()->withErrors(['message' => $result->message ?? 'Gagal memperbarui status.']);
        }
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
       
        // 🔄 Ambil daftar semua gudang
        $allgudangResponse = Http::withToken($token)->get('https://gudangku.web.id/api/gudangs');
        $allresponseJson = json_decode($allgudangResponse->body());
        $allgudangData = $allresponseJson->data->gudangs ?? [];


        // 🔄 Ambil daftar supplier
        $supplierResponse = Http::withToken($token)->get('https://gudangku.web.id/api/suppliers');
        $supplierJson = json_decode($supplierResponse->body());
        $supplierData = $supplierJson->data->suppliers ?? [];

        // 🔍 Cari gudang yang cocok dengan asal_barang
        $matchedGudang = collect($allgudangData)->first(function ($gudang) use ($data) {
            return trim(strtolower($gudang->nama_gudang)) === trim(strtolower($data->asal_barang));
        });

        // 🔍 Cari supplier yang cocok dengan asal_barang
        $matchedSupplier = collect($supplierData)->first(function ($supplier) use ($data) {
            return trim(strtolower($supplier->nama_gudang_toko)) === trim(strtolower($data->asal_barang));
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

        // jika seller dari gudang
        if ($matchedGudang) {
            $seller = new Buyer([
                'name' => $matchedGudang->nama_gudang ?? 'Gudang Tidak Diketahui',
                'custom_fields' => [
                    'Alamat' => $matchedGudang->alamat ?? '-',
                    'Telepon' => $matchedGudang->no_telepon ?? '-',
                ],
            ]);
        } elseif ($matchedSupplier) { // jika seller dari supplier
            $seller = new Buyer([
                'name' => $matchedSupplier->nama_gudang_toko ?? 'Supplier Tidak Diketahui',
                'custom_fields' => [
                    'Alamat' => $matchedSupplier->alamat ?? '-',
                    'Telepon' => $matchedSupplier->no_telepon ?? '-',
                ],
            ]);
        }

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
