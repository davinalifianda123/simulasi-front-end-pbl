<x-default-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 m-6">
        @if (session('error'))
        <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('retur-barang.store') }}" method="POST" id="returForm">
            @csrf

            <div class="mb-6">
                <div class="mb-6">
                    <label for="id_penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                    <select id="id_penanggung_jawab" name="id_penanggung_jawab" class="shadow bg-white p-3 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Pilih Staff Gudang</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>{{ $user->nama_user }}</option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="tanggal_retur" class="block text-sm font-medium text-gray-700">Tanggal Retur</label>
                    <input type="datetime-local" id="tanggal_retur" name="tanggal_retur" value="{{ old('tanggal_retur') ?? now()->format('Y-m-d\TH:i') }}" class="bg-white p-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @error('tanggal_retur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_pengiriman_barang" class="block text-sm font-medium text-gray-700">Orderan Barang</label>
                    <select id="id_pengiriman_barang" name="id_pengiriman_barang" class="shadow bg-white p-3 mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Pilih Orderan</option>
                        @foreach($pengirimanBarangs as $pengiriman)
                            <option value="{{ $pengiriman->id }}" {{ old('id_pengiriman_barang') == $pengiriman->id ? 'selected' : '' }}>ID#{{ $pengiriman->id }} - {{ \Carbon\Carbon::parse($pengiriman->tanggal_pengiriman)->format('d M Y') }}</option>
                        @endforeach
                    </select>
                    @error('id_pengiriman_barang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="alasan_retur" class="block text-sm font-medium text-gray-700">Alasan Retur</label>
                    <textarea id="alasan_retur" name="alasan_retur" rows="4" class="p-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('alasan_retur') }}</textarea>
                    @error('alasan_retur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Barang yang Diretur</h3>

                <div id="detailBarangContainer">
                    <div class="mb-6 p-4 border border-gray-200 rounded-md bg-gray-50 detail-barang-item">
                        <div class="flex justify-between mb-2">
                            <h4 class="font-medium">Detail Barang #1</h4>
                            <button type="button" class="remove-item text-red-600 hover:text-red-800">
                                Hapus
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Barang</label>
                                <select name="id_barang[]" class="p-3 barang-select mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                                    <option value="">Pilih Barang</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} - {{ $barang->gudang->nama_gudang ?? $barang->toko->nama_toko }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message mt-1 text-sm text-red-500"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <input type="number" name="jumlah_barang_retur[]" min="1" class="p-3 jumlah-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                                <p class="error-message mt-1 text-sm text-red-500"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2 mb-6">
                    <button type="button" id="addBarangButton" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Barang
                    </button>
                </div>
            </div>

            <div class="flex justify-between border-t border-gray-200 pt-6">
                <a href="{{ route('retur-barang.index') }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit" id="submitButton" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <template id="detailBarangTemplate">
        <div class="mb-6 p-4 border border-gray-200 rounded-md bg-gray-50 detail-barang-item">
            <div class="flex justify-between mb-2">
                <h4 class="font-medium">Detail Barang #</h4>
                <button type="button" class="remove-item text-red-600 hover:text-red-800">
                    Hapus
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Barang</label>
                    <select name="id_barang[]" class="p-3 barang-select mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                        <option value="">Pilih Barang</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                    <p class="error-message mt-1 text-sm text-red-500"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah_barang_retur[]" min="1" class="p-3 jumlah-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md bg-white">
                    <p class="error-message mt-1 text-sm text-red-500"></p>
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBarangButton = document.getElementById('addBarangButton');
            const detailBarangContainer = document.getElementById('detailBarangContainer');
            const detailBarangTemplate = document.getElementById('detailBarangTemplate');
            const returForm = document.getElementById('returForm');
            const submitButton = document.getElementById('submitButton');

            updateRemoveButtonState();
            updateDetailItemNumber();

            addBarangButton.addEventListener('click', function() {
                const newItem = detailBarangTemplate.content.cloneNode(true);
                detailBarangContainer.appendChild(newItem);
                updateRemoveButtonState();
                updateDetailItemNumber();
            });

            detailBarangContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-item')) {
                    const item = event.target.closest('.detail-barang-item');
                    item.remove();
                    updateRemoveButtonState();
                    updateDetailItemNumber();
                }
            });

            submitButton.addEventListener('click', function(event) {
                validateForm(event);
            });

            function updateRemoveButtonState() {
                const items = document.querySelectorAll('.detail-barang-item');
                const isDisabled = items.length <= 1;

                items.forEach(item => {
                    item.querySelector('.remove-item').disabled = isDisabled;
                });
            }

            function updateDetailItemNumber() {
                const items = document.querySelectorAll('.detail-barang-item');
                items.forEach((item, index) => {
                    item.querySelector('h4').textContent = `Detail Barang #${index + 1}`;
                });
            }

            function validateForm(event) {
                const detailItems = document.querySelectorAll('.detail-barang-item');
                let isValid = true;
                let errors = {};
                detailItems.forEach((item, index) => {
                    const barangSelect = item.querySelector('.barang-select');
                    const jumlahInput = item.querySelector('.jumlah-input');
                    const errorBarang = item.querySelectorAll('.error-message')[0];
                    const errorJumlah = item.querySelectorAll('.error-message')[1];

                    if (!barangSelect.value) {
                        errors['id_barang.' + index] = 'Barang harus dipilih';
                        errorBarang.textContent = 'Barang harus dipilih';
                        isValid = false;
                    } else {
                        errorBarang.textContent = '';
                    }

                    if (!jumlahInput.value || parseInt(jumlahInput.value) < 1) {
                        errors['jumlah_barang_retur.' + index] = 'Jumlah harus lebih dari 0';
                        errorJumlah.textContent = 'Jumlah harus lebih dari 0';
                        isValid = false;
                    } else {
                        errorJumlah.textContent = '';
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    alert('Terdapat kesalahan dalam form. Silakan periksa kembali.');
                }
            }
        });
    </script>
</x-default-layout>