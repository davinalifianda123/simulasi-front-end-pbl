<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori Barang</h1>
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-800">Kembali ke daftar</a>
        </div>
    
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="nama_kategori_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input 
                    type="text" 
                    name="nama_kategori_barang" 
                    id="nama_kategori_barang" 
                    value="{{ old('nama_kategori_barang') }}" 
                    class="p-2 w-full rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('nama_role') ? 'border-red-500' : 'border-gray-300' }}"
                    required
                >
                @error('nama_kategori_barang')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</x-default-layout>