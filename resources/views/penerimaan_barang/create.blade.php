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
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Tambah Penerimaan Barang</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk menambahkan penerimaan barang baru.</p>
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
        
            <form action="{{ route('penerimaan-di-pusats.store') }}" method="POST">
                @csrf
                
                <div class="mb-12">
                    {{-- Baris 1 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Kode Penerimaan --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="kode" class="text-sm font-medium text-gray-700">Kode Penerimaan</label>
                                <label for="kode" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="text" name="kode" class="w-full p-2 rounded-lg" placeholder="Input Kode Penerimaan" required>
                            @error('kode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Barang --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_barang" class="text-sm font-medium text-gray-700">Pilih Barang</label>
                                <label for="id_barang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_barang" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                                @endforeach
                            </select>
                            @error('id_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Satuan Berat --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_satuan_berat" class="text-sm font-medium text-gray-700">Pilih Satuan Berat</label>
                                <label for="id_satuan_berat" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_satuan_berat" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Satuan Berat</option>
                                @foreach ($satuanBerats as $satuanBerat)
                                    <option value="{{ $satuanBerat->id }}">{{ $satuanBerat->nama_satuan_berat }}</option>
                                @endforeach
                            </select>
                            @error('id_satuan_berat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Baris 2 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Jumlah Barang --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="jumlah_barang" class="text-sm font-medium text-gray-700">Jumlah Barang</label>
                                <label for="jumlah_barang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="number" name="jumlah_barang" class="w-full p-2 rounded-lg" placeholder="Input Jumlah Barang" required>
                            @error('jumlah_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Berat Satuan Barang --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="berat_satuan_barang" class="text-sm font-medium text-gray-700">Berat Satuan Barang</label>
                                <label for="berat_satuan_barang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="number" name="berat_satuan_barang" class="w-full p-2 rounded-lg" placeholder="Input Berat Satuan Barang" required>
                            @error('berat_satuan_barang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Tanggal --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="tanggal" class="text-sm font-medium text-gray-700">Pilih Tanggal</label>
                                <label for="tanggal" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="date" name="tanggal" class="w-full p-2 rounded-lg" required>
                            @error('tanggal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 3 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Pilih Jenis Penerimaan --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_jenis_penerimaan" class="text-sm font-medium text-gray-700">Pilih Jenis Penerimaan</label>
                                <label for="id_jenis_penerimaan" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_jenis_penerimaan" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Jenis Penerimaan</option>
                                @foreach ($jenisPenerimaans as $jenisPenerimaan)
                                    <option value="{{ $jenisPenerimaan->id }}">{{ $jenisPenerimaan->nama_jenis_penerimaan }}</option>
                                @endforeach
                            </select>
                            @error('id_jenis_penerimaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Asal Barang --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_asal_barang" class="text-sm font-medium text-gray-700">Pilih Asal Barang</label>
                                <label for="id_asal_barang" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_asal_barang" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Cabang</option>
                                @foreach ($asalBarangs as $asalBarang)
                                    <option value="{{ $asalBarang->id }}">{{ $asalBarang->nama_gudang_toko }}</option>
                                @endforeach
                            </select>
                            @error('id_asal_barang')
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
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>