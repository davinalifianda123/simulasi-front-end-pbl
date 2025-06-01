<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Edit Pengiriman Barang</h1>
                        <a href="{{ route('pusat-ke-cabang.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                    </div>
    
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    
                    <form action="{{ route('pusat-ke-cabang.update', $pengirimanBarang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-8">
                            <h2 class="text-lg font-medium text-gray-700 mb-4">Informasi Pengiriman</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Asal Barang Section -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Asal Barang</label>
                                    <div class="space-y-3">
                                        <select id="tipe_asal" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" disabled>
                                            <option value="gudang" {{ $pengirimanBarang->lokasiAsal->gudang ? 'selected' : '' }}>Gudang</option>
                                            <option value="toko" {{ $pengirimanBarang->lokasiAsal->toko ? 'selected' : '' }}>Toko</option>
                                        </select>
                                        
                                        <div id="asal_container">
                                            <select name="id_asal_barang" id="id_asal_barang" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="{{ $pengirimanBarang->id_asal_barang }}" selected>
                                                    {{ $pengirimanBarang->lokasiAsal->gudang->nama_gudang ?? $pengirimanBarang->lokasiAsal->toko->nama_toko ?? '' }}
                                                </option>
                                            </select>
                                            @error('id_asal_barang')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tujuan Pengiriman Section -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Pengiriman</label>
                                    <div class="space-y-3">
                                        <select id="tipe_tujuan" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" disabled>
                                            <option value="gudang" {{ $pengirimanBarang->lokasiTujuan->gudang != null ? 'selected' : '' }}>Gudang</option>
                                            <option value="toko" {{ $pengirimanBarang->lokasiTujuan->toko != null ? 'selected' : '' }}>Toko</option>
                                        </select>
                                        
                                        <div id="tujuan_container">
                                            <select name="id_tujuan_pengiriman" id="id_tujuan_pengiriman" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="{{ $pengirimanBarang->id_tujuan_pengiriman ?? '' }}" selected>
                                                    {{ $pengirimanBarang->lokasiTujuan->gudang->nama_gudang ?? $pengirimanBarang->lokasiTujuan->toko->nama_toko ?? '-' }}
                                                </option>
                                                @error('id_tujuan_pengiriaman')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="tanggal_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengiriman</label>
                                    <input type="datetime-local" name="tanggal_pengiriman" id="tanggal_pengiriman" value="{{ \Carbon\Carbon::parse($pengirimanBarang->tanggal_pengiriman)->format('Y-m-d\TH:i') }}" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                                    @error('tanggal_pengiriman')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="id_kurir" class="block text-sm font-medium text-gray-700 mb-1">Kurir</label>
                                    <select name="id_kurir" id="id_kurir" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="{{ $pengirimanBarang->id_kurir }}" selected>
                                            {{ $pengirimanBarang->kurir->nama_kurir }}
                                        </option>
                                    </select>
                                    @error('id_kurir')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="id_status_pengiriman" class="block text-sm font-medium text-gray-700 mb-1">Status Pengiriman</label>
                                    <select name="id_status_pengiriman" id="id_status_pengiriman" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($statusPengirimanBarangs as $status)
                                            <option value="{{ $status->id }}" {{ $status->id == $pengirimanBarang->id_status_pengiriman ? 'selected' : '' }}>
                                                {{ $status->nama_status ?? $status->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_status_pengiriman')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h2 class="text-lg font-medium text-gray-700 mb-4">Detail Barang</h2>
                            
                            <div id="detail-container">
                                @foreach($pengirimanBarang->detailPengirimanBarangs as $index => $detail)
                                    <div class="detail-item border border-gray-200 rounded p-4 mb-4">
                                        <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="col-span-2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
                                                <select name="barang_id[]" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="{{ $detail->barang->id }}" selected>
                                                        {{ $detail->barang->nama_barang }}
                                                    </option>
                                                </select>
                                                @error('barang_id')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-span-1">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                                <input type="number" name="jumlah[]" value="{{ $detail->jumlah }}" min="1" class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" readonly>
                                                @error('jumlah')
                                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-8">
                            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ini hanya untuk keperluan demonstrasi tampilan
            // pada form edit, dropdown sudah diatur disabled
            const tipeAsal = document.getElementById('tipe_asal');
            const tipeTujuan = document.getElementById('tipe_tujuan');
            
            // Containers
            const gudangAsalContainer = document.getElementById('gudang_asal_container');
            const tokoAsalContainer = document.getElementById('toko_asal_container');
            const gudangTujuanContainer = document.getElementById('gudang_tujuan_container');
            const tokoTujuanContainer = document.getElementById('toko_tujuan_container');
            
            // Toggle asal container visibility for demonstration
            if (tipeAsal) {
                tipeAsal.addEventListener('change', function() {
                    if (this.value === 'gudang') {
                        gudangAsalContainer.classList.remove('hidden');
                        tokoAsalContainer.classList.add('hidden');
                    } else {
                        gudangAsalContainer.classList.add('hidden');
                        tokoAsalContainer.classList.remove('hidden');
                    }
                });
            }
            
            // Toggle tujuan container visibility for demonstration
            if (tipeTujuan) {
                tipeTujuan.addEventListener('change', function() {
                    if (this.value === 'gudang') {
                        gudangTujuanContainer.classList.remove('hidden');
                        tokoTujuanContainer.classList.add('hidden');
                    } else {
                        gudangTujuanContainer.classList.add('hidden');
                        tokoTujuanContainer.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</x-default-layout>