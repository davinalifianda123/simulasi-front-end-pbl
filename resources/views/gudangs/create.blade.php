<x-default-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Gudang Baru
        </h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('gudangs.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="nama_gudang_toko" class="block text-gray-700 font-medium mb-2">Nama Gudang</label>
                    <input type="text" name="nama_gudang_toko" id="nama_gudang_toko" 
                        value="{{ old('nama_gudang_toko') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                    <input type="text" name="alamat" id="alamat" 
                        value="{{ old('alamat') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label for="no_telepon" class="block text-gray-700 font-medium mb-2">No Telepon</label>
                    <input type="text" name="no_telepon" id="no_telepon" 
                        value="{{ old('no_telepon') }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('gudangs.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        &larr; Kembali
                    </a>
                    <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-default-layout>
