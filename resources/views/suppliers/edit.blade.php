<x-default-layout>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Edit Supplier</h1>
        </div>

        <div class="p-4">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="nama_gudang_toko" class="block text-gray-700 font-medium mb-2">Nama Toko Supplier</label>
                    <input type="text" name="nama_gudang_toko" id="nama_gudang_toko" value="{{ old('nama_gudang_toko', $supplier->nama_gudang_toko) }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('nama_gudang_toko') ? 'border-red-500' : 'border-gray-300' }}" required>
                    @error('nama_gudang_toko')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('alamat') ? 'border-red-500' : 'border-gray-300' }}" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="no_telepon" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $supplier->no_telepon) }}" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('no_telepon') ? 'border-red-500' : 'border-gray-300' }}" required>
                    @error('no_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end mt-6">
                    <a href="{{ route('suppliers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-4 py-2 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>