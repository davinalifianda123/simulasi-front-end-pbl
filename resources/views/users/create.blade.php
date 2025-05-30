<!-- resources/views/users/create.blade.php -->
<x-default-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Pengguna Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="nama_user" id="nama_user" value="{{ old('nama_user') }}" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="id_role" class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="id_role" id="id_role" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" onchange="toggleAdditionalFieldsBasedOnRole()">
                                <option value="0">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option 
                                        value="{{ $role->id }}" 
                                        data-role-name="{{ $role->nama_role }}">
                                        {{ $role->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penempatan (Staff) - Ditampilkan secara kondisional -->
                        <div id="penempatan-container" class="mb-4 hidden">
                            <label for="penempatan" class="block text-sm font-medium text-gray-700">Penempatan</label>
                            <select name="penempatan" id="penempatan" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" onchange="toggleAdditionalFieldsBasedOnLocation()">
                                <option value="">-- Pilih Penempatan --</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Toko">Toko</option>
                            </select>
                            @error('penempatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Penempatan Gudang - Ditampilkan secara kondisional -->
                        <div id="penempatan-gudang-container" class="mb-4 hidden">
                            <label for="id_gudang" class="block text-sm font-medium text-gray-700">Gudang</label>
                            <select name="id_gudang" id="id_gudang" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $gudang)
                                    <option 
                                        value="{{ $gudang->id }}" 
                                        data-gudang-name="{{ $gudang->nama_gudang }}">
                                        {{ $gudang->nama_gudang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gudang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Penempatan toko - Ditampilkan secara kondisional -->
                        <div id="penempatan-toko-container" class="mb-4 hidden">
                            <label for="id_toko" class="block text-sm font-medium text-gray-700">Toko</label>
                            <select name="id_toko" id="id_toko" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" q>
                                <option value="">-- Pilih Toko --</option>
                                @foreach($tokos as $toko)
                                    <option 
                                        value="{{ $toko->id }}" 
                                        data-toko-name="{{ $toko->nama_toko }}">
                                        {{ $toko->nama_toko }}
                                    </option>
                                @endforeach
                            </select>
                            @error('toko')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat - Ditampilkan secara kondisional -->
                        <div id="alamat-container" class="mb-4 hidden">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. Telepon - Ditampilkan secara kondisional -->
                        <div id="telepon-container" class="mb-4 hidden">
                            <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" class="p-2 block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('no_telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mt-6 gap-12">
                            <a href="{{ route('users.index') }}" class="text-sm text-gray-600 underline">Kembali ke Daftar Pengguna</a>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 cursor-pointer">
                                Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function untuk menangani perubahan pada pemilihan role
        function toggleAdditionalFieldsBasedOnRole() {
            const roleSelect = document.getElementById('id_role');
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleName = selectedOption.getAttribute('data-role-name');
            
            const alamatContainer = document.getElementById('alamat-container');
            const teleponContainer = document.getElementById('telepon-container');
            const penempatanContainer = document.getElementById('penempatan-container');
            const alamatInput = document.getElementById('alamat');
            const teleponInput = document.getElementById('no_telepon');
            const penempatanInput = document.getElementById('penempatan');
            
            if (roleName === 'Supplier' || roleName === 'Buyer') {
                alamatContainer.classList.remove('hidden');
                teleponContainer.classList.remove('hidden');
                
                alamatInput.setAttribute('required', '');
                teleponInput.setAttribute('required', '');
            } else {
                alamatContainer.classList.add('hidden');
                teleponContainer.classList.add('hidden');

                alamatInput.removeAttribute('required');
                teleponInput.removeAttribute('required');
            }

            if (roleName === 'Staff') {
                penempatanContainer.classList.remove('hidden');
                penempatanInput.setAttribute('required', '');
            } else {
                penempatanContainer.classList.add('hidden');
                penempatanInput.removeAttribute('required');
            }
        }

        // Function untuk menangani perubahan pada pemilihan lokasi penempatan staff
        function toggleAdditionalFieldsBasedOnLocation() {
            const penempatanSelect = document.getElementById('penempatan');
            const selectedOption = penempatanSelect.options[penempatanSelect.selectedIndex];
            const jenisPenempatan = selectedOption.value;

            const gudangContainer = document.getElementById('penempatan-gudang-container');
            const tokoContainer = document.getElementById('penempatan-toko-container');
            const gudangInput = document.getElementById('id_gudang');
            const tokoInput = document.getElementById('id_toko');

            if (jenisPenempatan === "Gudang") {
                gudangContainer.classList.remove('hidden');
                gudangInput.setAttribute('required', '');
            } else { // toko
                gudangContainer.classList.add('hidden');
                gudangInput.removeAttribute('required');
            }
            
            if (jenisPenempatan === "Toko") {
                tokoContainer.classList.remove('hidden');
                tokoInput.setAttribute('required', '');
            } else {
                tokoContainer.classList.add('hidden');
                tokoInput.removeAttribute('required');
            }
        }

        // Panggil fungsi saat halaman dimuat (untuk handle old input)
        document.addEventListener('DOMContentLoaded', function() {
            toggleAdditionalFieldsBasedOnRole();
            toggleAdditionalFieldsBasedOnLocation();
        });
    </script>
</x-default-layout>