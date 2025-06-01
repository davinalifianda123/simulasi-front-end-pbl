<header class="bg-gray-50 z-10">
  <div class="flex items-center justify-between h-16   px-4 md:px-6 py-4.5">
      <!-- Mobile menu button -->
      <div class="sm:hidden">
          <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
              <span class="sr-only">Open main menu</span>
              <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
          </button>
      </div>
      
      <!-- Page title -->
      <div class="flex-1">
          <div class="flex flex-col">
              <h1 class="text-black text-xl font-semibold">
                  @yield('page-title', 'Dashboard')
              </h1>
              @hasSection('page-subtitle')
                  <p class="text-gray-500 text-sm font-normal mt-1">
                      @yield('page-subtitle')
                  </p>
              @endif
          </div>
      </div>

      <!-- Profile -->
      <div class="{{ request()->is('profile/*') ? 'hidden' : 'sm:flex md:flex'}} absolute inset-y-0 right-0 items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0" x-data="{ open: false }">
        
      <!-- Profile -->
        <div class="relative ml-3">
          <div>
            @if ($namaUser && $namaRole)
              <button type="button" class="relative flex items-center rounded-lg bg-[#F9F9F9] px-3 py-2 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-transparent focus:outline-none" @click="open = !open" :aria-expanded="open" aria-haspopup="true">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user menu</span>

                <!-- Image dengan Inisial Nama Pengguna-->
                <div class="size-8 rounded-full bg-[#31304D] flex items-center justify-center text-white font-medium text-xs mt-2">
                  {{ strtoupper(substr($namaUser, 0, 2)) }}
                </div>
                <div class="ml-2 flex flex-col items-start hidden sm:flex">
                  <span class="text-gray-900 font-medium text-sm">{{ $namaUser }}</span>
                  <span class="text-gray-500 text-xs">{{ $namaRole }}</span>
                </div>
                <svg class="ml-2 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
            @else
              <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Login</a>
            @endif

            <!-- Dropdown menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg focus:outline-none" @click.outside="open = false" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              @if ($namaUser && $namaRole)
                <div class="px-4 py-2 border-b border-opacity-5">
                  <p class="text-gray-900 font-medium">{{ $namaUser }}</p>
                  <p class="text-gray-500 text-sm">{{ $namaRole }}</p>
                </div>
                <a href="{{ route('profile.show', $namaUser) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                  <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  Profile
                </a>
                <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <svg class="mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              @endif
            </div>
          </div>
        </div>
      </div>
  </div>
</header>