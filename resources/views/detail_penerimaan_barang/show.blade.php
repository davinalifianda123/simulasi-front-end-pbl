<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b flex justify-between items-center gap-12">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detail Penerimaan Barang</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('penerimaan-barang.edit-detail', $detailPenerimaan->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded">
                    Edit
                </a>
                <form action="{{ route('penerimaan-barang.destroy-detail', $detailPenerimaan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                            <p class="text-sm font-medium text-gray-500">ID Penerimaan Barang</p>
                            <p class="text-base text-gray-900">{{ $detailPenerimaan->penerimaanBarang->id }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Barang</p>
                            <p class="text-base text-gray-900">{{ $detailPenerimaan->barang->nama_barang }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jumlah</p>
                            <p class="text-base text-gray-900">{{ $detailPenerimaan->jumlah }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Harga Beli</p>
                            <p class="text-base text-gray-900">Rp {{ $detailPenerimaan->harga_beli }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 border-t pt-4">
                <a href="{{ route('penerimaan-barang.show', $detailPenerimaan->id_penerimaan_barang) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; Kembali ke Daftar Penerimaan
                </a>
            </div>
        </div>
    </div>
</x-default-layout>