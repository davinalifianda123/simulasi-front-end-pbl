<x-default-layout>
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Edit Penerimaan Barang</h1>
        </div>
        
        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            <form action="{{ route('penerimaan-barang.update', $penerimaanBarang->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-3">Informasi Penerimaan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="id_supplier" class="block mb-2 text-sm font-medium text-gray-700">Supplier</label>
                            <select id="id_supplier" name="id_supplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('id_supplier', $penerimaanBarang->id_supplier) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_toko_supplier }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_supplier')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="id_gudang" class="block mb-2 text-sm font-medium text-gray-700">Gudang</label>
                            <select id="id_gudang" name="id_gudang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">Pilih Gudang</option>
                                @foreach($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}" {{ old('id_gudang', $penerimaanBarang->id_gudang) == $gudang->id ? 'selected' : '' }}>
                                        {{ $gudang->nama_gudang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_gudang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="tanggal_penerimaan" class="block mb-2 text-sm font-medium text-gray-700">Tanggal Penerimaan</label>
                            <input type="datetime-local" id="tanggal_penerimaan" name="tanggal_penerimaan" value="{{ old('tanggal_penerimaan', $penerimaanBarang->tanggal_penerimaan->format('Y-m-d\TH:i')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            @error('tanggal_penerimaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 border-t pt-6 flex justify-end">
                    <a href="{{ URL::previous() }}" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded mr-2">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>