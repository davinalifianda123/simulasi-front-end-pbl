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
                <h1 class="text-2xl font-bold text-gray-800">Tambah Barang</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk menambahkan barang baru.</p>
            </div>
        
            <form action="{{ route('barangs.store') }}" method="POST">
                @csrf
                
                <div class="mb-12">
                    <div class="flex items-center mb-2 gap-1">
                        <label for="nama_barang" class="text-sm font-medium text-gray-700">Nama Barang</label>
                        <label for="nama_barang" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input 
                        type="text" 
                        name="nama_barang" 
                        id="nama_barang" 
                        value="{{ old('nama_barang') }}" 
                        class="mb-6 p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('nama_barang') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Input Nama Barang"
                        required
                    >
                    @error('nama_barang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center mb-2 gap-1">
                        <label for="id_kategori_barang" class="text-sm font-medium text-gray-700">Pilih Kategori Barang</label>
                        <label for="id_kategori_barang" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <select name="id_kategori_barang" class="w-full p-2 rounded-lg mb-6">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['nama_kategori_barang'] }}</option>
                        @endforeach
                    </select>

                    @error('id_kategori_barang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center mb-2 gap-1">
                        <label for="id_satuan_berat" class="text-sm font-medium text-gray-700">Satuan Berat</label>
                        <label for="id_satuan_berat" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <select name="id_satuan_berat" class="w-full p-2 rounded-lg mb-6">
                        <option value="">Pilih Satuan Berat</option>
                        @foreach ($satuan_berats as $satuan)
                            <option value="{{ $satuan['id'] }}">{{ $satuan['nama_satuan_berat'] }}</option>
                        @endforeach
                    </select>

                    @error('id_satuan_berat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center mb-2 gap-1">
                        <label for="berat_satuan_barang" class="text-sm font-medium text-gray-700">Berat Satuan Barang</label>
                        <label for="berat_satuan_barang" class="text-sm font-medium text-red-600">*</label>
                    </div>
                    <input 
                        type="text" 
                        name="berat_satuan_barang" 
                        id="berat_satuan_barang" 
                        value="{{ old('berat_satuan_barang') }}" 
                        class="mb-6 p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('berat_satuan_barang') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="Input Berat Satuan Barang"
                        required
                    >
                    @error('berat_satuan_barang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center items-center gap-4 ">
                    <button type="button" class="bg-white hover:bg-red-600 text-[#161A30] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24" onclick="history.back(); return false;">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>