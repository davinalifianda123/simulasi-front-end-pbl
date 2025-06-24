<aside id="sidebar-multi-level-sidebar"
  class="fixed top-0 left-0 z-40 grid items-center w-64 shrink-0 h-screen transition-transform -translate-x-full translate-x-0 "
  aria-label="Sidebar">
    <div class="h-[95%] px-3 py-4 overflow-y-auto bg-[#161A30] rounded-xl shadow-lg mx-auto w-[95%] flex flex-col">
        <div class="flex items-center mb-4">
            <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25.529 32.7902L8.708 39.9998L24.5555 22.9637L40.2407 20.1333L25.529 32.7902Z" fill="url(#paint0_linear_4719_3880)"/>
                <path d="M26.0159 5.23365L8.00494 0L24.5555 22.964L40.2407 20.1335L26.0159 5.23365Z" fill="url(#paint1_linear_4719_3880)"/>
                <path d="M24.6095 22.9105L8.70799 40L0 19.5995L8.00486 0L24.6095 22.9105Z" fill="url(#paint2_radial_4719_3880)"/>
                <defs>
                <linearGradient id="paint0_linear_4719_3880" x1="24.4473" y1="23.2842" x2="27.0897" y2="31.9013" gradientUnits="userSpaceOnUse">
                <stop stop-color="#31304D"/>
                <stop offset="0.411667" stop-color="#68697E"/>
                <stop offset="1" stop-color="#B6BBC4"/>
                </linearGradient>
                <linearGradient id="paint1_linear_4719_3880" x1="18.8223" y1="-4.53939" x2="29.0842" y2="22.9966" gradientUnits="userSpaceOnUse">
                <stop stop-color="#31304D"/>
                <stop offset="1" stop-color="#B6BBC4"/>
                </linearGradient>
                <radialGradient id="paint2_radial_4719_3880" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(8.81616 22.3231) rotate(97.3134) scale(19.5449 12.0199)">
                <stop stop-color="#B6BBC4"/>
                <stop offset="1" stop-color="#31304D"/>
                </radialGradient>
                </defs>
                </svg>
            <span class="text-white text-lg font-semibold pl-1">Gudangku</span> <!-- Judul -->
        </div>
       <ul class="pl-2 flex-grow overflow-y-auto">
          <li>
            <a href="{{ route('dashboard.index') }}" class="flex items-center p-2 rounded-lg text-white  hover:bg-gray-700 group">
               <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C2.89543 2 2 2.89543 2 4V8C2 9.10457 2.89543 10 4 10H8C9.10457 10 10 9.10457 10 8V4C10 2.89543 9.10457 2 8 2H4ZM18 10C20.2091 10 22 8.20914 22 6C22 3.79086 20.2091 2 18 2C15.7909 2 14 3.79086 14 6C14 8.20914 15.7909 10 18 10ZM10 18C10 20.2091 8.20914 22 6 22C3.79086 22 2 20.2091 2 18C2 15.7909 3.79086 14 6 14C8.20914 14 10 15.7909 10 18ZM16 14C14.8954 14 14 14.8954 14 16V20C14 21.1046 14.8954 22 16 22H20C21.1046 22 22 21.1046 22 20V16C22 14.8954 21.1046 14 20 14H16Z" fill="#F0ECE5"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
          </li>
          <li>
             <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group  text-white hover:bg-gray-700" aria-controls="dropdown-aktivitas-gudang-pusat" data-collapse-toggle="dropdown-aktivitas-gudang-pusat">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4719_5289)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1.25C1.58579 1.25 1.25 1.58579 1.25 2C1.25 2.41421 1.58579 2.75 2 2.75H3C3.69036 2.75 4.25 3.30964 4.25 4V18.1454C3.51704 18.4421 3 19.1607 3 20C3 21.1046 3.89543 22 5 22C5.83934 22 6.55793 21.483 6.85462 20.75H22C22.4142 20.75 22.75 20.4142 22.75 20C22.75 19.5858 22.4142 19.25 22 19.25H6.85462C6.65168 18.7486 6.25135 18.3483 5.75 18.1454V4C5.75 2.48122 4.51878 1.25 3 1.25H2ZM8 7C8 5.89543 8.89543 5 10 5H18C19.1046 5 20 5.89543 20 7V15C20 16.1046 19.1046 17 18 17H10C8.89543 17 8 16.1046 8 15V7ZM12.25 8C12.25 7.58579 12.5858 7.25 13 7.25H15C15.4142 7.25 15.75 7.58579 15.75 8C15.75 8.41421 15.4142 8.75 15 8.75H13C12.5858 8.75 12.25 8.41421 12.25 8Z" fill="#F0ECE5"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_4719_5289">
                    <rect width="24" height="24" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    
                   <span class="flex-1 ms-3 text-left rtl:text-right break-words mr-2">Aktivitas Gudang Pusat</span>
                   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                   </svg>
             </button>
             <ul id="dropdown-aktivitas-gudang-pusat" class="hidden py-2 space-y-2">
                   <li>
                      <a href="{{ route('penerimaan-di-pusats.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Penerimaan Barang</a>
                   </li>
                   <li>
                      <a href="{{ route('pusat-ke-cabangs.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Pengiriman Barang</a>
                   </li>
                   <li>
                      <a href="{{ route('pusat-ke-suppliers.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Retur Barang</a>
                   </li>
             </ul>
          </li>
          <li>
             <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group  text-white hover:bg-gray-700" aria-controls="dropdown-aktivitas-gudang-cabang" data-collapse-toggle="dropdown-aktivitas-gudang-cabang">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_4719_5289)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1.25C1.58579 1.25 1.25 1.58579 1.25 2C1.25 2.41421 1.58579 2.75 2 2.75H3C3.69036 2.75 4.25 3.30964 4.25 4V18.1454C3.51704 18.4421 3 19.1607 3 20C3 21.1046 3.89543 22 5 22C5.83934 22 6.55793 21.483 6.85462 20.75H22C22.4142 20.75 22.75 20.4142 22.75 20C22.75 19.5858 22.4142 19.25 22 19.25H6.85462C6.65168 18.7486 6.25135 18.3483 5.75 18.1454V4C5.75 2.48122 4.51878 1.25 3 1.25H2ZM8 7C8 5.89543 8.89543 5 10 5H18C19.1046 5 20 5.89543 20 7V15C20 16.1046 19.1046 17 18 17H10C8.89543 17 8 16.1046 8 15V7ZM12.25 8C12.25 7.58579 12.5858 7.25 13 7.25H15C15.4142 7.25 15.75 7.58579 15.75 8C15.75 8.41421 15.4142 8.75 15 8.75H13C12.5858 8.75 12.25 8.41421 12.25 8Z" fill="#F0ECE5"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_4719_5289">
                    <rect width="24" height="24" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    
                   <span class="flex-1 ms-3 text-left rtl:text-right break-words mr-2">Aktivitas Gudang Cabang</span>
                   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                   </svg>
             </button>
             <ul id="dropdown-aktivitas-gudang-cabang" class="hidden py-2 space-y-2">
                   <li>
                      <a href="{{ route('penerimaan-di-cabangs.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Penerimaan Barang</a>
                   </li>
                   <li>
                      <a href="{{ route('cabang-ke-tokos.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Pengiriman Barang</a>
                   </li>
                   <li>
                      <a href="{{ route('cabang-ke-pusats.index') }}" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group  text-white hover:bg-gray-700">Retur Barang</a>
                   </li>
             </ul>
          </li>
       </ul>
       <x-footer />
    </div>
 </aside>
 
 