<x-default-layout>
    <div class="py-12">
        <div class="w-2xl max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 flex justify-between items-center gap-12">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Detail Pengiriman Barang') }}
                        </h2>
                        <a href="{{ route('pengiriman-barang.show', $detailPengirimanBarang->id_pengiriman_barang) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Kembali') }}
                        </a>
                    </div>

                    <div class="bg-gray-100 rounded-lg p-6">
                        <div class="grid grid-cols-1 gap-6">
                            <div class="bg-white p-4 rounded shadow grid grid-cols-2">
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-600">ID</h4>
                                    <p class="text-gray-800">{{ $detailPengirimanBarang->id }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-600">ID Barang</h4>
                                    <p class="text-gray-800">{{ $detailPengirimanBarang->id_barang ?? 'Tidak Ada' }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-600">Nama Barang</h4>
                                    <p class="text-gray-800">{{ $detailPengirimanBarang->barang->nama_barang ?? 'Barang tidak ditemukan' }}</p>
                                </div>

                                <div class="mb-4">
                                    <h4 class="text-sm font-semibold text-gray-600">Jumlah</h4>
                                    <p class="text-gray-800">{{ $detailPengirimanBarang->jumlah ?? 'Barang tidak ditemukan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>