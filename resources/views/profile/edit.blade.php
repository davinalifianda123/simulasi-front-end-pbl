@section('page-title', 'Edit Profile')
<x-default-layout>
    <div>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>
                        <form action="{{ route('profile.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Informasi Pengguna -->
                                <div class="bg-white p-6 rounded-lg ">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengguna</h3>
                                    
                                    <div class="space-y-4">                                       
                                        <div>
                                            <label for="nama_user" class="text-sm font-medium text-gray-500">Nama</label>
                                            <input type="text" id="nama_user" name="nama_user" value="{{ old('nama_user', $user->nama_user) }}" class="mt-1 p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('nama_user')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="email" class="text-sm font-medium text-gray-500">Email</label>
                                            <input type="email" id="email" value="{{ $user->email }}" class="mt-1 p-2 w-full bg-gray-100 text-gray-900 rounded-md" disabled>
                                        </div>
                                        
                                        <div>
                                            <label for="role" class="text-sm font-medium text-gray-500">Role</label>
                                            <input type="text" id="role" value="{{ $user->role }}" class="mt-1 p-2 w-full text-gray-900 rounded-md" disabled>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Informasi Password -->
                                <div class="bg-white p-6 rounded-lg">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="current_password" class="text-sm font-medium text-gray-500">Password Saat Ini</label>
                                             <input type="password" id="current_password" name="current_password" class="mt-1 p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('current_password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="password" class="text-sm font-medium text-gray-500">Password Baru</label>
                                            <input type="password" id="password" name="password" class="mt-1 p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <div>
                                            <label for="password_confirmation" class="text-sm font-medium text-gray-500">Konfirmasi Password Baru</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" class="mt-1 p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </div>

                                        <div class="mt-6 flex justify-end space-x-3">
                                            <a href="{{ route('profile.show', $user->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-300 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                                                Batal
                                            </a>
                                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
