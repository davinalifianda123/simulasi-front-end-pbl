@section('page-title', 'Aktivitas Gudang')
@section('page-subtitle', 'Penerimaan Barang')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="{{ route('pusat-ke-cabangs.create') }}" data-resource-name="Penerimaan Barang" data-route-name="penerimaan-di-pusats" data-editable="false" data-user-role="{{ $nama_role }}">
                <thead>
                    <tr>
                        @if(count($penerimaanDiPusats) > 0)
                            @foreach ($headings as $heading)
                            <th>
                                <span class="flex items-center">
                                    {{ $heading }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                    </svg>
                                </span>
                            </th>
                            @endforeach
                            <th>
                                <span class="flex items-center">Diterima</span>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penerimaanDiPusats as $penerimaanDiPusat)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $penerimaanDiPusat->id }}</td>
                            <td>{{ $penerimaanDiPusat->nama_barang }}</td>
                            <td>{{ $penerimaanDiPusat->asal_barang }}</td>
                            <td>{{ $penerimaanDiPusat->jumlah_barang }}</td>
                            <td>{{ $penerimaanDiPusat->tanggal }}</td>
                            <td>{{ $penerimaanDiPusat->jenis_penerimaan }}</td>
                            <td class="text-center">
                                <input id="default-checkbox" type="checkbox" name="diterima[]" value="{{ $penerimaanDiPusat->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-8">
                                <div class="w-full flex flex-col items-center">
                                    <img src="{{ asset('images/Nothing_found.png') }}" alt="Nothing Found" class="mx-auto w-64 h-64 object-contain">
                                    <a href="{{ route('penerimaan-di-pusats.create') }}" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200">
                                        + Tambah Penerimaan Barang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-default-layout>