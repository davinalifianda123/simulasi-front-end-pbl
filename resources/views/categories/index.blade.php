@section('page-title', 'Manajemen Barang')
@section('page-subtitle', 'Kategori Barang')
@include('components.dialogbox')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="{{ $nama_role == 'SuperAdmin' ? route('kategori-barangs.create') : '#' }}" data-resource-name="Kategori Barang" data-route-name="kategori-barangs" data-editable="true" data-deleteable="true" data-user-role="{{ $nama_role }}">
                <thead>
                    <tr>
                        @if(count($kategoriBarangs) > 0)
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
                    @forelse ($kategoriBarangs as $kategoriBarang)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td hidden>{{ $kategoriBarang->id }}</td>
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td>{{ $kategoriBarang->nama_kategori_barang }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-8">
                                <div class="w-full flex flex-col items-center">
                                    <img src="{{ asset('images/Nothing_found.png') }}" alt="Nothing Found" class="mx-auto w-64 h-64 object-contain">
                                    <a href="{{ route('kategori-barangs.create') }}" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200">
                                        + Tambah Kategori Barang
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