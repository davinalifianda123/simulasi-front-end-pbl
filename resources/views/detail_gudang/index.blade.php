@section('page-title', 'Manajemen Barang')
@section('page-subtitle', 'Stok Barang')
@include('components.dialogbox')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- Tabel --}}
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="{{ $detailGudangs[0]->stok_opname == 'Aktif' ? '#' :route('detail-gudangs.create')}}" data-resource-name="Detail Barang" data-route-name="detail-gudangs" data-editable="true" data-deleteable="true">
                <thead>
                    <tr>
                        @if(count($detailGudangs) > 0)
                            <th hidden>ID</th>
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
                            <td hidden>{{ $detailGudang->id }}</td>
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
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
    @if($detailGudangs[0]->stok_opname == 'Aktif')
        <div id="bottom-banner" tabindex="-1" class="fixed bottom-0 start-0 z-50 flex justify-between w-full p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center mx-auto">
                <p class="flex items-center text-sm font-normal text-gray-500">
                    <span class="inline-flex p-1 me-3 bg-gray-200 rounded-full w-6 h-6 items-center justify-center">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                        </svg>

                        <span class="sr-only">Info</span>
                    </span>
                    <span>Gudang sedang di opname, tidak bisa menambah data untuk saat ini.
                        @if($nama_role == 'SuperAdmin')
                            <a href="{{ route('gudangs.index') }}" class="flex items-center ms-0 text-sm font-medium text-blue-600 md:ms-1 md:inline-flex">
                                Ubah status opname disini
                                <svg class="w-3 h-3 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        @endif
                    </span>
                </p>
            </div>
            <div class="flex items-center">
                <button data-dismiss-target="#bottom-banner" type="button" class="shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close banner</span>
                </button>
            </div>
        </div>
    @endif
</x-default-layout>
