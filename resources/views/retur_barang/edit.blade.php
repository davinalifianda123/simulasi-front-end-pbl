<x-default-layout>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 w-3xl m-6">
        <form action="{{ route('retur-barang.update', $returBarang->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <div class="mb-6">
                    <label for="id_penanggung_jawab" class="block text-sm font-medium text-gray-700">Penanggung Jawab</label>
                    <select id="id_penanggung_jawab" name="id_penanggung_jawab" class="shadow p-3 bg-white mt-1 block w-full pl-3 pr-10 py-2 text-base focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md {{ $errors->has('id_user') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="{{ $returBarang->user->id }}">{{ $returBarang->user->nama_user }}</option>
                    </select>
                    @error('id_user')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="tanggal_retur" class="block text-sm font-medium text-gray-700">Tanggal Retur</label>
                    <input type="datetime-local" id="tanggal_retur" name="tanggal_retur" value="{{ old('tanggal_retur', \Carbon\Carbon::parse($returBarang->tanggal_retur)->format('Y-m-d\TH:i')) }}" class="p-3 bg-white mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('tanggal_retur') ? 'border-red-500' : 'border-gray-300' }}" readonly>
                    @error('tanggal_retur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_status_retur" class="block text-sm font-medium text-gray-700">Status Retur</label>
                    <select id="id_status_retur" name="id_status_retur" class="p-3 shadow bg-white mt-1 block w-full pl-3 pr-10 py-2 text-base focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md {{ $errors->has('id_status_retur') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="">Pilih Status</option>
                        @foreach($statusReturs as $status)
                            <option value="{{ $status->id }}" {{ old('id_status_retur', $returBarang->id_status_retur) == $status->id ? 'selected' : '' }}>{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                    @error('id_status_retur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_pengiriman_barang" class="block text-sm font-medium text-gray-700">Pengiriman Barang</label>
                    <select id="id_pengiriman_barang" name="id_pengiriman_barang" class="mt-1 block w-full pl-3 pr-10 py-2 text-base focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md {{ $errors->has('id_pengiriman_barang') ? 'border-red-500' : 'border-gray-300' }}">
                        <option value="{{ $returBarang->id_pengiriman_barang }}">ID#{{ $returBarang->id_pengiriman_barang }} - {{ \Carbon\Carbon::parse($returBarang->pengirimanBarang->tanggal_pengiriman)->format('d M Y') }}</option>
                    </select>
                    @error('id_pengiriman_barang')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="alasan_retur" class="block text-sm font-medium text-gray-700">Alasan Retur</label>
                    <textarea id="alasan_retur" name="alasan_retur" rows="4" class="p-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('alasan_retur') ? 'border-red-500' : 'border-gray-300' }}">{{ old('alasan_retur', $returBarang->alasan_retur) }}</textarea>
                    @error('alasan_retur')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Barang yang Diretur</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Detail
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Barang
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($returBarang->detailReturBarangs as $detail)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $detail->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $detail->barang->nama_barang ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $detail->jumlah_barang_retur }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-between border-t border-gray-200 pt-6 mt-6">
                <a href="{{ route('retur-barang.show', $returBarang->id) }}" class="bg-gray-200 py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-default-layout>