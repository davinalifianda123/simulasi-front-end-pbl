<div class="flex items-center space-x-2">
  <!-- View -->
  <a
    href="{{ $rute_lihat }}"
    aria-label="Lihat"
    class="bg-gray-500 hover:bg-gray-600 text-white focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg p-2 inline-flex items-center"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
    </svg>
  </a>

  <!-- Delete -->
 <form 
    action="{{ route('pusat-ke-cabang.destroy', $row->id) }}" 
    method="POST"
    onsubmit="return confirm('Yakin ingin menghapus pengiriman ini?');"
>
    @csrf
    @method('DELETE')
    <button 
        type="submit" 
        class="bg-red-600 hover:bg-red-700 text-white rounded-lg p-2 inline-flex items-center"
        aria-label="Hapus"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</form>

</div>
