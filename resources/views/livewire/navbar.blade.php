
<nav class="bg-gray-800" x-data="{ mobileMenuOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="-ml-2 mr-2 flex items-center">
                    <!-- Mobile menu button -->
                    <button type="button" class="md:hidden relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu" aria-expanded="false"
                            @click="mobileMenuOpen = !mobileMenuOpen">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!-- Menu icon (Hamburger) -->
                        <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!-- Close icon (X) -->
                        <svg x-show="mobileMenuOpen" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-shrink-0 items-center bg-white rounded-[50px] w-[200px] h-[55px] self-center justify-center ">
                    <img src="{{ Vite::asset('resources/images/logo_covadis_2016.png') }}" alt="Logo" class="h-8 w-auto" />
                </div>
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <a href="/" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white {{ request()->is('/') ? 'border border-white' : '' }}" aria-current="page">Activiteiten</a>
                </div>
                @role('admin')
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <a href="/admin/activities" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white {{ request()->is('admin/activities') ? 'border border-white' : '' }}" aria-current="page">Activiteiten beheren</a>
                </div>
                <div class="hidden md:ml-6 md:flex md:items-center md:space-x-4">
                    <a href="/admin/users" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white {{ request()->is('admin/users') ? 'border border-white' : '' }}" aria-current="page">Gebruikers beheren</a>
                </div>
                @endrole
            </div>
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <!-- Profile icon can go here -->
                </div>
                <div class="hidden md:ml-4 md:flex md:flex-shrink-0 md:items-center">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3" x-data="{ profileMenuOpen: false }">
                        <div>
                            <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="absolute -inset-1.5"></span>
                                <span class="sr-only">Open user menu</span>
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500"><span class="font-medium leading-none text-white">{{ Auth::user()->getInitials() }}</span></span>
                            </button>
                        </div>

                        <div x-show="profileMenuOpen" @click.outside="profileMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            @if(request()->is('profiel'))
                                <a href="/" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Dashboard</a>
                            @else
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Jouw Profiel</a>
                            @endif
                            <livewire:logout />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:leave="transition ease-in duration-75">
            <div class="flex flex-col px-2 pt-2 pb-3 space-y-1 sm:px-3 w-[100%] text-center">
                <div class="relative self-center mb-2" x-data="{ profileMenuOpen: false }" >
                    <div>
                        <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-500"><span class="font-medium text-[30px] leading-none text-white">{{ Auth::user()->getInitials() }}</span></span>
                        </button>
                    </div>

                    <div x-show="profileMenuOpen" @click.outside="profileMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        @if(request()->is('profiel'))
                            <a href="/" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Dashboard</a>
                        @else
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 w-[100%] text-start" role="menuitem" tabindex="-1" id="user-menu-item-0">Jouw Profiel</a>
                        @endif
                        <livewire:logout />
                    </div>
                </div>

                <a href="/" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white {{ request()->is('/') ? 'border border-white' : '' }}">Activiteiten</a>
                @role('admin')
                <a href="/admin/activities" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white {{ request()->is('admin/activities') ? 'border border-white' : '' }}">Activiteiten beheren</a>
                <a href="/admin/users" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white {{ request()->is('admin/users') ? 'border border-white' : '' }}">Gebruikers beheren</a>
                @endrole
            </div>
        </div>
    </div>
</nav>
