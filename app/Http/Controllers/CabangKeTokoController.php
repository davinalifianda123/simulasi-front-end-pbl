<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Str;

class CabangKeTokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/cabang-ke-tokos');

        $result = [];
        if ($response->successful()) {
            $result = json_decode($response->body());
            $result = $result->data;
        }

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('pengiriman_barang_cabang.index', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'cabangKeTokos' => $result->cabangKeTokos ?? [],
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
        $response = Http::withToken($token)->get('https://gudangku.web.id/api/cabang-ke-tokos/create');
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

        return view('pengiriman_barang_cabang.create', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'id_lokasi' => $id_lokasi ?? '',
            'barangs' => $data->barang ?? [],
            'cabangs' => $data->cabang ?? [],
            'tokos' => $data->toko ?? [],
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
            $response = Http::withToken($token)->post('https://gudangku.web.id/api/cabang-ke-tokos', $request->all());

            $result = json_decode($response->body());

            if ($response->successful() && $result->status) {
                return redirect()->route('cabang-ke-tokos.index')->with('success', $result->message);
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
    private function getCabangKeTokoById($id)
    {
        $token = request()->cookie('jwt_token');
        $response = Http::withToken($token)->get("https://gudangku.web.id/api/cabang-ke-tokos/{$id}");

        if ($response->successful()) {
            $result = json_decode($response->body());
            return $result->data ?? null;
        }

        return null;
    }

    public function show(Request $request, string $id)
    {
        $cabangKeToko = $this->getCabangKeTokoById($id);

        $nama_user = $request->attributes->get('nama_user');
        $nama_role = $request->attributes->get('nama_role');

        return view('pengiriman_barang_cabang.show', [
            'nama_user' => $nama_user ?? '',
            'nama_role' => $nama_role ?? '',
            'cabangKeToko' => $cabangKeToko,
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
        $token = request()->cookie('jwt_token');

        $response = Http::withToken($token)->put("https://gudangku.web.id/api/cabang-ke-tokos/{$id}", $request->all());

        if ($response->successful()) {
            return redirect()->route('cabang-ke-tokos.index')->with('success', 'Status penerimaan berhasil diperbarui.');
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

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/cabang-ke-tokos/{$id}/deactivate");

        if ($response->successful()) {
            return redirect()->route('cabang-ke-tokos.index')
                            ->with('success', $response->json()['message'] ?? 'Data berhasil dihapus.');
        } else {
            $error = $response->json()['message'] ?? 'Gagal menghapus data.';

            return redirect()->route('cabang-ke-tokos.index')
                            ->with('error', $error);
        }
    }

    public function updateStatus(string $id)
    {
        $token = request()->cookie('jwt_token');
        $payload = [
            'id_status' => request()->input('id_status'),
        ];

        $response = Http::withToken($token)->patch("https://gudangku.web.id/api/cabang-ke-tokos/{$id}", $payload);

        $responseBody = $response->json();

        $message = $responseBody['message'] ?? ($response->successful() ? 'Status berhasil diperbarui.' : 'Gagal memperbarui status.');

        return redirect()->route('cabang-ke-tokos.index')->with($response->successful() ? 'success' : 'error', $message);
    }

    public function downloadInvoice($id)
    {
        $data = $this->getCabangKeTokoById($id);
        $nama_user = request()->attributes->get('nama_user');

        $buyer = new Buyer([
            'name' => $nama_user ?? 'Pusat Tidak Diketahui',
            'custom_fields' => [
                'Gudang' => $data->nama_cabang ?? '-',
                'Tanggal Penerimaan' => $data->tanggal ?? '-',
            ],
        ]);

        $seller = new Buyer([
            'name' => $data->nama_toko ?? 'Toko Tidak Diketahui',
            'custom_fields' => [
                'Alamat' => $matchedToko->alamat ?? '-',
                'Telepon' => $matchedToko->no_telepon ?? '-',
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
            ->filename('Invoice-Pengiriman-Cabang-' . Str::slug($data->id ?? 'no-id'))
            ->addItem($item)
            ->logo(public_path('images/Logo-invoice.png'));

        return $invoice->stream(); // atau ->download()
    }
}
