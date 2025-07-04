@section('page-title', 'Profile Pengguna')
@include('components.dialogbox')
<x-default-layout>
        <div class="mx-auto sm:px-6">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                        <!-- Informasi Pengguna -->
                        <div class="bg-white p-6">
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

                            <div class="mt-6 pt-6 border-gray-200">
                                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                    <a href="{{ route('profile.edit', $user->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
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
</x-default-layout>