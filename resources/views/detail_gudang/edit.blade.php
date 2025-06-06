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
                <h1 class="text-2xl font-bold text-gray-800">Edit Detail Barang</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk memperbarui detail barang.</p>
            </div>

            @if ($errors->has('api'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <span class="block sm:inline">{{ $errors->first('api') }}</span>
                </div>
            @endif

            @if ($errors->has('exception'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <span class="block sm:inline">{{ $errors->first('exception') }}</span>
                </div>
            @endif

            <form action="{{ route('detail-gudangs.update', $detailGudang->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-12">
                    {{-- Baris 1 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Pilih Barang --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_barang" class="text-sm font-medium text-gray-700">Barang</label>
                                <label for="id_barang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_barang" class="w-full p-2 rounded-lg" readonly>
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('id_barang', $detailGudang->id_barang) == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Lokasi --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_gudang" class="text-sm font-medium text-gray-700">Lokasi</label>
                                <label for="id_gudang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_gudang" class="w-full p-2 rounded-lg bg-gray-100 cursor-not-allowed" readonly>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($gudangs as $gudang)
                                    @if ($gudang->id == $id_lokasi)
                                        <option value="{{ $gudang->id }}" selected>{{ $gudang->nama_gudang_toko }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('id_gudang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Baris 2 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Pilih Satuan Berat --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_satuan_berat" class="text-sm font-medium text-gray-700">Pilih Satuan Berat</label>
                                <label for="id_satuan_berat" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_satuan_berat" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Satuan Berat</option>
                                @foreach ($satuanBerats as $satuanBerat)
                                    <option value="{{ $satuanBerat->id }}" {{ old('id_satuan_berat', $detailGudang->id_satuan_berat) == $satuanBerat->id ? 'selected' : '' }}>{{ $satuanBerat->nama_satuan_berat }}</option>
                                @endforeach
                            </select>
                            @error('id_satuan_berat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Jumlah Stok --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="jumlah_stok" class="text-sm font-medium text-gray-700">Jumlah Stok</label>
                                <label for="jumlah_stok" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input 
                                type="number" 
                                name="jumlah_stok" 
                                id="jumlah_stok" 
                                value="{{ old('jumlah_stok', $detailGudang->jumlah_stok) }}" 
                                @if (!isset($detailGudang) || $detailGudang->stok_opname == 0) class="p-2 w-full rounded-lg bg-gray-100" readonly @else class="p-2 w-full rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 {{ $errors->has('jumlah_stok') ? 'border-red-500' : 'border-gray-300' }}" required @endif
                            >
                            @error('jumlah_stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 3 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Stok Opname --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="stok_opname" class="text-sm font-medium text-gray-700">Stok Opname</label>
                                <label for="stok_opname" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="number" name="stok_opname" class="w-full p-2 rounded-lg bg-gray-100" value="{{ old('stok_opname', $detailGudang->stok_opname) }}" readonly>
                            <p class="text-sm text-gray-500">0 = Nonaktif, 1 = Aktif</p>
                            @error('stok_opname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
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