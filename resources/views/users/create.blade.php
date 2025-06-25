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
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Tambah User</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk menambahkan user baru.</p>
            </div>

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                
                <div class="mb-12">
                    {{-- Baris 1 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Nama User --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="nama_user" class="text-sm font-medium text-gray-700">Nama User</label>
                                <label for="nama_user" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="text" name="nama_user" class="w-full p-2 rounded-lg" placeholder="Input Nama User" required>
                            @error('nama_user')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Email --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                                <label for="email" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="email" name="email" class="w-full p-2 rounded-lg" placeholder="Input Email" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Baris 2 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Password --}}
                        <div class="flex flex-col w-full relative">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <label class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="password" name="password" id="password" class="w-full p-2 rounded-lg pr-10" placeholder="Input Password" required>
                            
                            {{-- Eye Icon --}}
                            <span onclick="togglePassword('password', 'togglePasswordIcon')" class="absolute right-3 top-10 cursor-pointer">
                                <svg id="togglePasswordIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path id="eyeIconConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m2.257-1.798A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.232 5.151M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l18-18" />
                                    <path id="eyeIconOutline" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"/>
                                </svg>
                            </span>

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="flex flex-col w-full relative">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <label class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 rounded-lg pr-10" placeholder="Ulangi Password" required>

                            {{-- Eye Icon --}}
                            <span onclick="togglePassword('password_confirmation', 'toggleConfirmIcon')" class="absolute right-3 top-10 cursor-pointer">
                                <svg id="toggleConfirmIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path id="eyeIconConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m2.257-1.798A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.232 5.151M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l18-18" />
                                    <path id="eyeIconOutlineConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    {{-- Baris 3 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Role --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_role" class="text-sm font-medium text-gray-700">Pilih Role</label>
                                <label for="id_role" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_role" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role['id'] }}">{{ $role['nama_role'] }}</option>
                                @endforeach
                            </select>
                            @error('id_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- Pilih Lokasi --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_lokasi" class="text-sm font-medium text-gray-700">Pilih Lokasi</label>
                                <label for="id_lokasi" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_lokasi" class="w-full p-2 rounded-lg">
                                <option value="">Pilih Lokasi</option>
                                @foreach ($lokasi as $lokasi)
                                    <option value="{{ $lokasi['id'] }}">{{ $lokasi['nama_lokasi'] }}</option>
                                @endforeach
                            </select>
                            @error('id_lokasi')
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

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            // Ganti ikon eye/eye-off
            icon.innerHTML = isPassword 
                ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path id="eyeIconOutlineConfirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z"/>`
                : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.961 9.961 0 012.293-3.95m2.257-1.798A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.953 9.953 0 01-4.232 5.151M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l18-18" />`;
        }
    </script>
</body>
</html>