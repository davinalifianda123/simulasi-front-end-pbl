<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <title>Gudangku</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-gudangku.svg') }}" type="image/x-icon">
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Kategori Barang</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk memperbarui kategori barang.</p>
            </div>

            <form action="{{ route('kategori-barangs.update', $kategoriBarang->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-12">
                    <div class="flex items-center mb-2 gap-1">
                        <label for="nama_kategori_barang" class="text-sm font-medium text-gray-700">Nama Kategori</label>
                        <label for="nama_kategori_barang" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input 
                        type="text" 
                        name="nama_kategori_barang" 
                        id="nama_kategori_barang" 
                        value="{{ old('nama_kategori_barang', $kategoriBarang->nama_kategori_barang) }}" 
                        class="p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('nama_kategori_barang') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Input Nama Kategori Barang"
                        required
                    >
                    @error('nama_kategori_barang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center items-center gap-4 ">
                    <button type="button" class="bg-white hover:bg-red-600 text-[#161A30] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24" onclick="history.back(); return false;">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>