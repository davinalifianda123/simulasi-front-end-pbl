<x-default-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6 gap-12">
                <h2 class="text-2xl font-semibold text-gray-800">Detail Orderan</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Data Pengiriman -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Orderan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">                    
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pengiriman</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->tanggal_pengiriman->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Asal Barang</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->lokasiAsal->toko->nama_toko ?? $pengirimanBarang->lokasiAsal->gudang->nama_gudang ?? 'Tidak ada' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Kurir</p>
                        <p class="text-lg font-medium">{{ $pengirimanBarang->kurir->nama_kurir ?? 'Tidak ada' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500">Status Pengiriman</p>
                        <p class="itext-lg font-medium">
                            {{ $pengirimanBarang->statusPengiriman?->nama_status ?? 'Tidak ada' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Barang</h3>
                </div>
                
                @if($pengirimanBarang->detailPengirimanBarangs->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">Belum ada detail barang.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengirimanBarang->detailPengirimanBarangs as $index => $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $detail->barang?->nama_barang ?? 'Tidak ada' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($detail->jumlah) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('orders.detail.show', [$pengirimanBarang->id, $detail->id]) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-default-layout>