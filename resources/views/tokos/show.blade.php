<x-default-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-col gap-6">
                    <div class="flex justify-between items-center gap-12">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Detail Toko
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informasi Toko</h3>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">ID Toko</h4>
                                <p class="text-gray-800">{{ $toko->id }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Nama Toko</h4>
                                <p class="text-gray-800">{{ $toko->nama_toko }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Jenis Toko</h4>
                                <p class="text-gray-800">{{ $toko->jenisToko->nama_jenis_toko ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                @if ($toko->flag == 1)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Aktif</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Nonaktif</span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Kontak & Lokasi</h3>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Alamat</h4>
                                <p class="text-gray-800">{{ $toko->alamat }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-500">Nomor Telepon</h4>
                                <p class="text-gray-800">{{ $toko->no_telepon }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="{{ route('tokos.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            &larr; Kembali ke Daftar Gudang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>