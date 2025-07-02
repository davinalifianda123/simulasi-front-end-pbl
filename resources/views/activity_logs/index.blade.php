@section('page-title', 'Log Aktivitas')
<x-default-layout :nama-user="$nama_user" :nama-role="$nama_role">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-center items-center">
            <table id="export-table" data-create-route="#" data-resource-name="Activity Log" data-route-name="activity-logs" data-editable="false" data-show-action="false">
                <thead>
                    <tr>
                        @if(count($activityLogs) > 0)
                            <th>
                                <span class="flex items-center">
                                    ID
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                    </svg>
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Nama User
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                    </svg>
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Aktivitas
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                    </svg>
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Tanggal Aktivitas
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                    </svg>
                                </span>
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $log)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="font-medium text-gray-900 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td>{{ $log->nama_user }}</td>
                            <td>{{ $log->aktivitas }}</td>
                            <td>{{ $log->tanggal_aktivitas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8">
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
</x-default-layout>