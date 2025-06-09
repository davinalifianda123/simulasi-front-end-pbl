@section('page-title', 'Management Gudang')
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
            <table id="export-table" data-create-route="{{ route('gudangs.create') }}" data-resource-name="Gudang" data-route-name="gudangs" data-editable="true">
                <thead>
                    <tr>
                        @if(count($gudangs) > 0)
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
                            <th>Mode Opname</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gudangs as $gudang)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $gudang->id }}</td>
                            <td>{{ $gudang->nama_gudang }}</td>
                            <td>{{ $gudang->alamat }}</td>
                            <td>{{ $gudang->no_telepon }}</td>
                            <td>{!! $gudang->status == 'Aktif' ? '<span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Aktif</span>' : '<span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Nonaktif</span>' !!}</td>
                            <td>
                                <form 
                                    action="{{ route('gudangs.toggle', $gudang->id) }}" 
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengubah status gudang ini?');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" aria-label="Toggle Status" class="relative inline-flex items-center h-8 w-16 rounded-full transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2  {{ $gudang->status == 'Nonaktif' ? 'bg-green-600 focus:ring-green-500'  : 'bg-red-300 focus:ring-red-500' }}">
                                        <span class="sr-only">Toggle Status</span>

                                        {{-- Lingkaran --}}
                                        <span class="inline-block w-6 h-6 transform rounded-full bg-white shadow-md transition duration-300 ease-in-out 
                                            {{ $gudang->status == 'Aktif' ? 'translate-x-8' : 'translate-x-1' }}">
                                            @if ($gudang->status == 'Aktif')
                                                {{-- Silang --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-600 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @else
                                                {{-- Centang --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 p-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @endif
                                        </span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8">
                                <div class="w-full flex flex-col items-center">
                                    <img src="{{ asset('images/Nothing_found.png') }}" alt="Nothing Found" class="mx-auto w-64 h-64 object-contain">
                                    <a href="{{ route('gudangs.create') }}" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200">
                                        + Tambah Gudang
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