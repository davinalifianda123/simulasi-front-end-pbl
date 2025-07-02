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
    <div class="flex items-center justify-between min-h-screen bg-gray-100">
        <div class="mx-10 my-10 lg:my-0">
            <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 overflow-y-auto lg:h-164">
                <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl">
                Daftar Barang
                </h5>
                <p class="text-sm font-normal text-gray-500">Berikut adalah barang yang ada di gudang.</p>
                <ul class="my-4 space-y-3">
                    @foreach ($detailGudangs as $detailGudang)
                        <li>
                            <div class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow">
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $detailGudang->nama_barang }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $detailGudang->jumlah_stok }} Stok
                                    </p>
                                </div>
                                <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded-sm">{{ $detailGudang->nama_gudang }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="lg:mx-5">
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
                    
                    {{-- Field that is always visible --}}
                    <div class="mb-6">
                        {{-- Pilih Jenis Penerimaan --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_jenis_penerimaan" class="text-sm font-medium text-gray-700">Pilih Jenis Penerimaan</label>
                                <label for="id_jenis_penerimaan" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_jenis_penerimaan" id="jenisPenerimaan" class="w-full p-2 rounded-lg bg-gray-100" disabled>
                                @foreach ($jenisPenerimaans as $jenisPenerimaan)
                                    <option value="{{ $jenisPenerimaan->id }}" {{ strtolower($jenisPenerimaan->nama_jenis_penerimaan) === 'pengiriman' ? 'selected' : '' }}>
                                        {{ $jenisPenerimaan->nama_jenis_penerimaan }}
                                    </option>
                                @endforeach
                            </select>
                            @php
                                $pengiriman = collect($jenisPenerimaans)->firstWhere('nama_jenis_penerimaan', 'pengiriman');
                            @endphp

                            <input type="hidden" name="id_jenis_penerimaan" value="{{ $pengiriman ? $pengiriman->id : '' }}">

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
                                {{-- Pilih Asal Barang --}}
                                <div class="flex flex-col w-full">
                                    <div class="flex items-center mb-2 gap-1">
                                        <label for="id_asal_barang" class="text-sm font-medium text-gray-700">Pilih Asal Barang</label>
                                        <label for="id_asal_barang" class="text-sm font-medium text-red-600">*</label>
                                    </div>
                                    <select name="id_asal_barang" id="asalBarang" class="w-full p-2 rounded-lg">
                                        <option value="">Pilih Asal Barang</option>
                                        @foreach ($asalBarangs as $asalBarang)
                                            <option value="{{ $asalBarang->id }}" data-tipe="{{ $asalBarang->tipe_asal }}">{{ $asalBarang->nama_gudang }}</option>
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
                            <button type="submit" class="bg-[#161A30] text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:w-100"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisPenerimaan = document.getElementById('jenisPenerimaan');
            const asalBarang = document.getElementById('asalBarang');
            const additionalFields = document.getElementById('additionalFields');
            const originalOptions = Array.from(asalBarang.options);

            jenisPenerimaan.addEventListener('change', function () {
                if (this.value) {
                    additionalFields.classList.remove('hidden');
                } else {
                    additionalFields.classList.add('hidden');
                }

                const selectedJenis = this.options[this.selectedIndex].text.toLowerCase();
                asalBarang.innerHTML = '';
                asalBarang.appendChild(originalOptions[0]);

                let tipeYangDicari = '';
                if (selectedJenis.includes('pengiriman')) {
                    tipeYangDicari = 'supplier';
                } else if (selectedJenis.includes('retur')) {
                    tipeYangDicari = 'cabang';
                }

                originalOptions.forEach(option => {
                    if (option.value !== '' && option.dataset.tipe === tipeYangDicari) {
                        asalBarang.appendChild(option);
                    }
                });
            });

            // Trigger default selection and show fields
            jenisPenerimaan.dispatchEvent(new Event('change'));
        });
    </script>
</body>
</html>