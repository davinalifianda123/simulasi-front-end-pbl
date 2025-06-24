<div id="status-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-800/75">
    <div class="bg-white rounded-lg shadow-md p-6 w-96">
        <h2 class="text-lg font-bold">Ubah Status Pengiriman</h2>
        <p class="text-sm text-gray-600 mb-4">Silakan pilih status baru untuk pengiriman ini.</p>
        <form method="POST" action="" id="status-form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="status-id">

            <select name="id_status" id="status-select" class="w-full p-2 rounded-lg">
                @foreach ($statuses as $status)
                    @continue($status->id == 4) {{-- Lewati status dengan id 4 --}}
                    <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                @endforeach
            </select>


            <div class="flex justify-center items-center gap-4 mt-5">
                    <button type="button" class="bg-white hover:bg-red-600 text-[#161A30] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24" onclick="closeModal()">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#E3E3E3] hover:bg-[#161A30] text-[#777777] hover:text-white px-4 py-2 rounded-lg transition duration-200 h-fit drop-shadow w-24">
                        Save
                    </button>
                </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id, currentStatusId, routeUrl) {
        const modal = document.getElementById('status-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Set hidden input & selected option
        document.getElementById('status-id').value = id;
        document.getElementById('status-select').value = currentStatusId;

        // Set dynamic form action URL
        document.getElementById('status-form').action = routeUrl;
    }

    function closeModal() {
        const modal = document.getElementById('status-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush
