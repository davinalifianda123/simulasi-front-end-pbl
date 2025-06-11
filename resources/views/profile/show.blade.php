@section('page-title', 'Profile Pengguna')
<x-default-layout>
        <div class="mx-auto sm:px-6">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 border-l-4 border-green-500 rounded-lg" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Pengguna -->
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengguna</h3>
                            
                            <div class="space-y-4">                                
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
                                    <p class="text-base text-gray-900">{{ $user->role }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Gudang</p>
                                    <p class="text-base text-gray-900">{{ $user->lokasi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-default-layout>