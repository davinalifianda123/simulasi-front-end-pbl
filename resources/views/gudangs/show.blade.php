<x-default-layout>
    <div class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Gudang</h1>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">ID</label>
                <div class="mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-900">
                    {{ $gudang->id }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Gudang</label>
                <div class="mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-900">
                    {{ $gudang->nama_gudang_toko }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <div class="mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-900">
                    {{ $gudang->alamat }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">No Telepon</label>
                <div class="mt-1 border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-900">
                    {{ $gudang->no_telepon ?? '-' }}
                </div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('gudang.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                &larr; Kembali
            </a>
        </div>
    </div>
</x-default-layout>
