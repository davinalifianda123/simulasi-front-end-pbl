<x-default-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                Edit Barang
            </h2>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded m-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    
        <div class="border-t border-gray-200">
            <form action="{{ route('barangs.update', $detailGudang->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required 
                            class="py-2 px-3 border mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('nama_barang')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="id_kategori" id="id_kategori" required
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('id_kategori', $barang->id_kategori_barang) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori_barang }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="jumlah_stok" class="block text-sm font-medium text-gray-700">Jumlah Stok</label>
                        <input type="number" name="jumlah_stok" id="jumlah_stok" value="{{ old('jumlah_stok', $detailGudang->jumlah_stok) }}" required min="0"
                            class="py-2 px-3 border mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @error('jumlah_stok')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                </div>
    
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('barangs.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>