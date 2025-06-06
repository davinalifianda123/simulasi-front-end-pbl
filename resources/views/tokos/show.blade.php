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

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Detail Toko</h1>

        <div class="mb-4">
            <label class="text-sm text-gray-500">ID</label>
            <p class="text-lg font-medium text-gray-800">{{ $toko->id }}</p>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-500">Nama Toko</label>
            <p class="text-lg font-medium text-gray-800">{{ $toko->nama_gudang_toko }}</p>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-500">Alamat</label>
            <p class="text-lg font-medium text-gray-800">{{ $toko->alamat }}</p>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-500">No Telepon</label>
            <p class="text-lg font-medium text-gray-800">{{ $toko->no_telepon }}</p>
        </div>

        <div class="flex justify-end">
            <button onclick="history.back();" type="button" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
                Kembali
            </button>
        </div>
    </div>
</body>
</html>