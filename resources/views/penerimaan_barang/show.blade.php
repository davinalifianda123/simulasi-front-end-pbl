<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b flex justify-between items-center gap-12">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Penerimaan Barang</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('penerimaan-barang.edit', $penerimaanBarang->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('penerimaan-barang.destroy', $penerimaanBarang->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Informasi Penerimaan</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Supplier</p>
                            <p class="text-base text-gray-900">{{ $penerimaanBarang->supplier->nama_toko_supplier }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Gudang</p>
                            <p class="text-base text-gray-900">{{ $penerimaanBarang->gudang->nama_gudang }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Penerimaan</p>
                            <p class="text-base text-gray-900">{{ $penerimaanBarang->tanggal_penerimaan->format('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-8">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-700">Detail Barang</h2>
                    <a href="{{ route('penerimaan-barang.create-detail', $penerimaanBarang->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded text-sm">
                        + Tambah Barang
                    </a>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    @if($penerimaanBarang->detailPenerimaanBarang->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($penerimaanBarang->detailPenerimaanBarang as $index => $detail)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->barang->nama_barang }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->jumlah }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->barang->berat }} gr</td>
                                            <td class="px-4 py-3 text-sm">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('penerimaan-barang.show-detail', $detail->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                        Detail
                                                    </a>
                                                    <a href="{{ route('penerimaan-barang.edit-detail', $detail->id) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('penerimaan-barang.destroy-detail', $detail->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus detail barang ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Belum ada data detail barang</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-6 border-t pt-4">
                <a href="{{ route('penerimaan-barang.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; Kembali ke Daftar Penerimaan
                </a>
            </div>
        </div>
    </div>
</x-default-layout>