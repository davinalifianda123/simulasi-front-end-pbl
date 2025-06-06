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
    <link rel="shortcut icon" href="{{ asset('images/logo-gudangku.svg') }}" type="image/x-icon">
</head>
<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Pelanggan</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk memperbarui data pelanggan.</p>
            </div>

            <form action="{{ route('tokos.update', $toko->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-12">
                    <div class="flex items-center mb-2 gap-1">
                        <label for="nama_gudang_toko" class="text-sm font-medium text-gray-700">Nama Pelanggan</label>
                        <label for="nama_gudang_toko" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input
                        type="text"
                        name="nama_gudang_toko"
                        id="nama_gudang_toko"
                        value="{{ old('nama_gudang_toko', $toko->nama_gudang_toko) }}"
                        class="mb-6 p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Input Nama Toko"
                        required
                    >
                    @error('nama_gudang_toko')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center mb-2 gap-1">
                        <label for="alamat" class="text-sm font-medium text-gray-700">Alamat</label>
                        <label for="alamat" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input
                        type="text"
                        name="alamat"
                        id="alamat"
                        value="{{ old('alamat', $toko->alamat) }}"
                        class="mb-6 p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Input Alamat"
                        required
                    >
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center mb-2 gap-1">
                        <label for="no_telepon" class="text-sm font-medium text-gray-700">No Telepon</label>
                        <label for="no_telepon" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input
                        type="text"
                        name="no_telepon"
                        id="no_telepon"
                        value="{{ old('no_telepon', $toko->no_telepon) }}"
                        class="mb-6 p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        placeholder="Input No Telepon"
                        required
                    >
                    @error('no_telepon')
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