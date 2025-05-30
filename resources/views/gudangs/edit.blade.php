<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6 w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Gudang</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('gudang.update', $gudang->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama_gudang_toko" class="block text-gray-700 font-medium mb-2">Nama Gudang</label>
                <input type="text" name="nama_gudang_toko" id="nama_gudang_toko"
                    value="{{ old('nama_gudang_toko', $gudang->nama_gudang_toko) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                <input type="text" name="alamat" id="alamat"
                    value="{{ old('alamat', $gudang->alamat) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-6">
                <label for="no_telepon" class="block text-gray-700 font-medium mb-2">No Telepon</label>
                <input type="text" name="no_telepon" id="no_telepon"
                    value="{{ old('no_telepon', $gudang->no_telepon) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('gudang.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    &larr; Kembali
                </a>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded transition duration-300">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</x-default-layout>
