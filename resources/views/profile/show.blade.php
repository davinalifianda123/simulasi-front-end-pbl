@section('page-title', 'Profile')
<x-default-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6 flex justify-between items-center gap-12">
                        <h2 class="text-2xl font-bold text-gray-800">
                            Profil Pengguna
                        </h2>
                    </div>

                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informasi Pengguna -->
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengguna</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">ID Pengguna</p>
                                        <p class="text-base text-gray-900">{{ $user->id }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Nama</p>
                                        <p class="text-base text-gray-900">{{ $user->nama_user }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <p class="text-base text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Role</p>
                                        <p class="text-base text-gray-900">{{ $user->role->nama_role }}</p>
                                    </div>

                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Gudang</p>
                                        <p class="text-base text-gray-900">{{ $user->lokasi->nama_gudang_toko }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
                                        <p class="text-base text-gray-900">
                                            @if($user->flag == 1)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informasi Tambahan -->
                            <div class="bg-white p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Akun</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Tanggal Bergabung</p>
                                        <p class="text-base text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Terakhir Diperbarui</p>
                                        <p class="text-base text-gray-900">{{ $user->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <h4 class="text-md font-medium text-gray-700 mb-3">Aksi</h4>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <a href="{{ route('profile.edit', $user->nama_user) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Edit Profil
                                        </a>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>