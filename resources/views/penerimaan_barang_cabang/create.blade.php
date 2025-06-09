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
        
            <form action="{{ route('penerimaan-di-cabangs.store') }}" method="POST">
                @csrf
                
                {{-- Field that is always visible --}}
                <div class="mb-6">
                    {{-- Pilih Jenis Penerimaan --}}
                    <div class="flex flex-col w-full">
                        <div class="flex items-center mb-2 gap-1">
                            <label for="id_jenis_penerimaan" class="text-sm font-medium text-gray-700">Pilih Jenis Penerimaan</label>
                            <label for="id_jenis_penerimaan" class="text-sm font-medium text-red-600">*</label>
                        </div>
                        <select name="id_jenis_penerimaan" id="jenisPenerimaan" class="w-full p-2 rounded-lg">
                            <option value="">Pilih Jenis Penerimaan</option>
                            @foreach ($jenisPenerimaans as $jenisPenerimaan)
                                <option value="{{ $jenisPenerimaan->id }}">{{ $jenisPenerimaan->nama_jenis_penerimaan }}</option>
                            @endforeach
                        </select>
                        @error('id_jenis_penerimaan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Wrapper for fields that are initially hidden --}}
                <div id="additionalFields" class="hidden">
                    <div class="mb-12">
                        {{-- Baris 1 --}}
                        <div class="mb-6 flex justify-center items-center gap-4">
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
                        </div>
                        
                        {{-- Baris 2 --}}
                        <div class="mb-6 flex justify-center items-center gap-4">
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
                            {{-- Gudang Cabang --}}
                            <input type="text" name="id_cabang" class="w-full p-2 rounded-lg" placeholder="Input Kode Cabang" value="{{ $id_lokasi }}" hidden>
                            {{-- Pilih Asal Barang --}}
                            <div class="flex flex-col w-full">
                                <div class="flex items-center mb-2 gap-1">
                                    <label for="id_asal_barang" class="text-sm font-medium text-gray-700">Pilih Asal Barang</label>
                                    <label for="id_asal_barang" class="text-sm font-medium text-red-600">*</label>
                                </div>
                                <select name="id_asal_barang" id="asalBarang" class="w-full p-2 rounded-lg">
                                    <option value="">Pilih Asal Barang</option>
                                    @foreach ($asalBarangs as $asalBarang)
                                        <option value="{{ $asalBarang->id }}" data-tipe="{{ $asalBarang->tipe_asal_cabang }}">{{ $asalBarang->nama_gudang }}</option>
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
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisPenerimaan = document.getElementById('jenisPenerimaan');
            const asalBarang = document.getElementById('asalBarang');
            const additionalFields = document.getElementById('additionalFields'); // Get the wrapper div
            const originalOptions = Array.from(asalBarang.options);

            jenisPenerimaan.addEventListener('change', function () {
                // Show/hide the additional fields based on selection
                if (this.value) {
                    additionalFields.classList.remove('hidden');
                } else {
                    additionalFields.classList.add('hidden');
                }

                // Existing logic to filter 'asalBarang'
                const selectedJenis = this.options[this.selectedIndex].text.toLowerCase();

                // Clear all options except the first one
                asalBarang.innerHTML = '';
                asalBarang.appendChild(originalOptions[0]); // re-add "Pilih Asal Barang"

                let tipeYangDicari = '';
                if (selectedJenis.includes('pengiriman')) {
                    tipeYangDicari = 'pusat';
                } else if (selectedJenis.includes('retur')) {
                    tipeYangDicari = 'toko';
                }

                // Filter and re-add the appropriate options
                originalOptions.forEach(option => {
                    if (option.value !== '' && option.dataset.tipe === tipeYangDicari) {
                        asalBarang.appendChild(option);
                    }
                });
            });
        });
    </script>
</body>
</html>