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
                <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
                <p class="text-sm text-gray-600 mb-4">Silakan isi form di bawah ini untuk memperbarui data user.</p>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-12">
                    {{-- Baris 1 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Nama User --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="nama_user" class="text-sm font-medium text-gray-700">Nama User</label>
                                <label for="nama_user" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <input type="text" name="nama_user" class="bg-gray-100 w-full p-2 rounded-lg" value="{{ old('nama_user', $user->nama_user) }}" placeholder="Input Nama User" readonly>
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
                            <input type="email" name="email" class="bg-gray-100 w-full p-2 rounded-lg" value="{{ old('email', $user->email) }}" placeholder="Input Email" readonly>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Baris 2 --}}
                    <div class="mb-6 flex justify-center items-center gap-4">
                        {{-- Role --}}
                        <div class="flex flex-col w-full">
                            <div class="flex items-center mb-2 gap-1">
                                <label for="id_role" class="text-sm font-medium text-gray-700">Pilih Role</label>
                                <label for="id_role" class="text-sm font-medium text-red-600">*</label>
                            </div>
                            <select name="id_role" class="bg-gray-100 w-full p-2 rounded-lg" readonly>
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $role->id == old('id_role', $user->id_role) ? 'selected' : '' }}>{{ $role->nama_role }}</option>
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
                            <select name="id_lokasi" class="bg-gray-100 w-full p-2 rounded-lg" readonly>
                                <option value="">Pilih Lokasi</option>
                                @foreach ($lokasi as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ $lokasi->id == old('id_lokasi', $user->id_lokasi) ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
                                @endforeach
                            </select>
                            @error('id_lokasi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-center items-center gap-4">
                    <button type="button" class="bg-white hover:bg-red-600 text-[#161A30] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24" onclick="history.back(); return false;">
                        Cancel
                    </button>
                    <button type="submit" name="reset_password" value="1" class="bg-yellow-300 hover:bg-yellow-500 text-gray-800 hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-36">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>