@section('page-title', 'Manajemen Barang')
@section('page-subtitle', 'Stok Barang')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        
        {{-- Pesan Session Success dan Error --}}
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

        {{-- Tabel --}}
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="{{ route('detail-gudangs.create') }}" data-resource-name="Detail Barang" data-route-name="detail-gudangs" data-editable="true">
                <thead>
                    <tr>
                        @if(count($detailGudangs) > 0)
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
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailGudangs as $detailGudang)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $detailGudang->id }}</td>
                            <td>{{ $detailGudang->nama_barang }}</td>
                            <td>{{ $detailGudang->nama_gudang }}</td>
                            <td>{{ $detailGudang->jumlah_stok }}</td>
                            <td>{!! $detailGudang->stok_opname == 'Aktif' ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Aktif</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Nonaktif</span>' !!}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8">
                                <div class="w-full flex flex-col items-center">
                                    <img src="{{ asset('images/Nothing_found.png') }}" alt="Nothing Found" class="mx-auto w-64 h-64 object-contain">
                                    <a href="{{ route('detail-gudangs.create') }}" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200">
                                        + Tambah Detail Barang
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
