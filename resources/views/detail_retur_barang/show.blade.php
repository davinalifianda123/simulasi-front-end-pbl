<x-default-layout>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Detail Barang Retur #{{ $detailReturBarang->id }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('detail-retur-barang.edit', $detailReturBarang->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
                <form action="{{ route('detail-retur-barang.destroy', $detailReturBarang->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
                </form>
                <a href="{{ route('retur-barang.show', $detailReturBarang->id_retur) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Kembali</a>
            </div>
        </div>
    
        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">ID Retur Barang</p>
                    <p class="text-lg">{{ $detailReturBarang->id_retur }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Barang</p>
                    <p class="text-lg">{{ $detailReturBarang->barang->nama_barang ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Jumlah Barang Retur</p>
                    <p class="text-lg">{{ $detailReturBarang->jumlah_barang_retur }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Dibuat</p>
                    <p class="text-lg">{{ \Carbon\Carbon::parse($detailReturBarang->created_at)->format('d M Y H:i') }}</p>
                </div>
            </div>
    
            <div class="mt-8 border-t pt-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Retur Barang</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">User</p>
                        <p class="text-lg">{{ $detailReturBarang->returBarang->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal Retur</p>
                        <p class="text-lg">{{ \Carbon\Carbon::parse($detailReturBarang->returBarang->tanggal_retur)->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Status Retur</p>
                        <p class="text-lg">{{ $detailReturBarang->returBarang->statusRetur->nama_status ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pengiriman Barang</p>
                        <p class="text-lg">{{ $detailReturBarang->returBarang->pengirimanBarang->no_referensi ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm font-medium text-gray-500">Alasan Retur</p>
                        <p class="text-lg">{{ $detailReturBarang->returBarang->alasan_retur }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>