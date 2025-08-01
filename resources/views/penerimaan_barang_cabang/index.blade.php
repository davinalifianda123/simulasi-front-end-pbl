@section('page-title', 'Aktivitas Gudang')
@section('page-subtitle', 'Penerimaan Barang')
@include('components.dialogbox')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="{{ $status_opname || $nama_role === 'Supervisor' ? '#' :route('penerimaan-di-cabangs.create') }}" data-resource-name="Penerimaan Barang" data-route-name="penerimaan-di-cabangs" data-editable="false" data-deleteable="false" data-user-role="{{ $nama_role }}" data-show-action="{{ $nama_role !== 'Supervisor' ? 'true' : 'false' }}">
                <thead>
                    <tr>
                        @if(count($penerimaanDiCabangs) > 0)
                            <th hidden>ID</th>
                            @foreach ($headings as $heading)
                                @if(
                                    ($nama_role === 'Supervisor' && $heading !== 'Sudah Diterima') ||
                                    (in_array($nama_role, ['Admin', 'SuperAdmin']) && $heading !== 'Verifikasi') ||
                                    (!in_array($nama_role, ['Supervisor', 'Admin', 'SuperAdmin']))
                                )
                                    <th>
                                        <span class="flex items-center">
                                            {{ $heading }}
                                            <svg class="w-4 h-4 ms-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                            </svg>
                                        </span>
                                    </th>
                                @endif
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penerimaanDiCabangs as $penerimaanDiCabang)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td hidden>{{ $penerimaanDiCabang->id }}</td>
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td>{{ $penerimaanDiCabang->nama_barang }}</td>
                            <td>{{ $penerimaanDiCabang->asal_barang }}</td>
                            <td>{{ $penerimaanDiCabang->jumlah_barang }}</td>
                            <td>{{ $penerimaanDiCabang->tanggal }}</td>
                            <td>{{ $penerimaanDiCabang->jenis_penerimaan }}</td>
                            {{-- Tampilkan checkbox hanya jika BUKAN Supervisor --}}
                            @if($nama_role !== 'Supervisor')
                                <td class="text-center">
                                    <form method="POST" action="{{ route('penerimaan-di-cabangs.update', $penerimaanDiCabang->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="diterima" value="1">
                                        <button type="submit">
                                            <input type="checkbox"
                                                {{ $penerimaanDiCabang->diterima ? 'checked' : '' }}
                                                onclick="this.form.submit(); event.preventDefault();"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
                                        </button>
                                    </form>
                                </td>
                            @endif

                            {{-- Tampilkan verifikasi hanya jika BUKAN Admin/SuperAdmin --}}
                            @if(!in_array($nama_role, ['Admin', 'SuperAdmin']))
                                @php
                                    $idVerifikasi = $penerimaanDiCabang->id_verifikasi;
                                    $statusBadge = match($idVerifikasi) {
                                        2 => 'bg-green-100 text-green-700',
                                        3 => 'bg-red-100 text-red-700',
                                        default => null
                                    };
                                @endphp
                                <td class="flex gap-2">
                                    @if ($statusBadge)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge }}">
                                            {{ $penerimaanDiCabang->jenis_verifikasi }}
                                        </span>
                                    @else
                                        <!-- Tombol Diverifikasi -->
                                        <form method="POST" action="{{ route('penerimaan-di-cabangs.update', $penerimaanDiCabang->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id_verifikasi" value="2">
                                            <button type="submit"
                                                    class="group text-green-700 border border-green-700 hover:bg-green-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                <svg class="w-3 h-3 text-green-700 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 11.917 9.724 16.5 19 7.5"/>
                                                </svg>
                                                <span class="sr-only">Diverifikasi</span>
                                            </button>
                                        </form>
                                        <!-- Tombol Tidak Diverifikasi -->
                                        <form method="POST" action="{{ route('penerimaan-di-cabangs.update', $penerimaanDiCabang->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id_verifikasi" value="3">
                                            <button type="submit"
                                                    class="group text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-1 text-center inline-flex items-center">
                                                <svg class="w-3 h-3 text-red-700 group-hover:text-white" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18 17.94 6M18 18 6.06 6"/>
                                                </svg>
                                                <span class="sr-only">Tidak Diverifikasi</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="py-8">
                                <div class="w-full flex flex-col items-center">
                                    <img src="{{ asset('images/Nothing_found.png') }}" alt="Nothing Found" class="mx-auto w-64 h-64 object-contain">
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($status_opname)
        <div id="bottom-banner" tabindex="-1" class="fixed bottom-0 start-0 z-50 flex justify-between w-full p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex items-center mx-auto">
                <p class="flex items-center text-sm font-normal text-gray-500">
                    <span class="inline-flex p-1 me-3 bg-gray-200 rounded-full w-6 h-6 items-center justify-center">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                        </svg>

                        <span class="sr-only">Info</span>
                    </span>
                    <span>Gudang sedang di opname, tidak bisa menerima barang untuk saat ini.
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