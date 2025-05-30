<x-default-layout>
    <div class="py-12">
        <div class="w-2xl max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col gap-6 p-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Toko Baru
                </h2>

                <div class="bg-white">
                    <form action="{{ route('tokos.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700 mb-1">Nama Toko</label>
                            <input type="text" id="nama_toko" name="nama_toko" value="{{ old('nama_toko') }}" required
                                class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            @error('nama_toko')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="id_jenis_toko" class="block text-sm font-medium text-gray-700 mb-1">Jenis Toko</label>
                            <select id="id_jenis_toko" name="id_jenis_toko" required
                                class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Pilih Jenis Toko</option>
                                @foreach ($jenisTokos as $jenisToko)
                                    <option value="{{ $jenisToko->id }}" {{ old('id_jenis_toko') == $jenisToko->id ? 'selected' : '' }}>
                                        {{ $jenisToko->nama_jenis_toko }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis_toko')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="3" required
                                class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                                class="p-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            @error('no_telepon')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('tokos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>