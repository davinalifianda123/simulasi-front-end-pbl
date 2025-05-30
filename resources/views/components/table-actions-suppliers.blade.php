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

  <!-- Edit -->
  <a 
    href="{{ $rute_edit }}"
    aria-label="Ubah"
    class="bg-gray-800 hover:bg-[#B6BBC4] text-white focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg p-2 inline-flex items-center"
  >
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    </svg>
  </a>

  <!-- Delete -->
  <form 
    action="{{ route('suppliers.deactivate', $row->id) }}"
    method="post"
    onsubmit="return confirm('Yakin ingin menghapus supplier ini?');"
  >
    @csrf
    @method('PATCH')

    <button 
      type="submit" 
      aria-label="Nonaktifkan"
      class="bg-red-600 hover:bg-red-700 text-white focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg p-2 inline-flex items-center"
    >
      <!-- Trash Icon -->
      <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
      <path d="M20.5001 6H3.5" stroke-linecap="round"/>
      <path d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5" stroke-linecap="round"/>
      <path d="M9.5 11L10 16" stroke-linecap="round"/>
      <path d="M14.5 11L14 16" stroke-linecap="round"/>
      <path d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"/>
      </svg>
    </button>
  </form>


</div>
