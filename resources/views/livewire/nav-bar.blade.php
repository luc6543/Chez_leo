<nav class="md:items-start !fixed z-10 top-0 left-0 w-screen navbar-expand-lg bg-[#0f172b] lg:bg-[#0f172b] px-4 px-lg-5 py-3 py-lg-3 flex flex-col lg:flex-row" x-data="{navBarShown : false}">
    <div class="flex gap-5 w-full items-center justify-around lg:justify-start">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Chez Leo</h1>
        </a>
        <button class="navbar-toggler" type="button" @click="navBarShown = !navBarShown">
            <span class="fa fa-bars"></span>
        </button>
    </div>
    {{-- hamburger menu --}}
    <div style="display:none" x-show="navBarShown" x-collapse id="navbarCollapse">
        <div class="lg:hidden flex-col pl-0 mb-0 list-none flex ms-auto w-fit py-0 pe-4">
            <a href="/">Home</a>
            <a href="/over-ons">Over ons</a>
            <a href="/menu">Menu</a>
            <a href="/recenties">Recenties</a>
            @auth
                <li class="w-20">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-[#FEA116] ">Account <i style="display:none" x-show="!open" class="bi bi-chevron-down"></i> <i style="display:none" x-show="open" class="bi bi-chevron-up"></i></button>
                            <div style="display:none" x-show="open"x-collapse @click.away="open = false" class="mt-2 w-48 bg-[#0f172b] rounded-md shadow-lg py-1 z-20">
                                <a href="/profile" class="block px-4 py-2 text-[#FEA116]">Profiel</a>
                                <form method="post" action="/logout" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 pt-2 text-[#FEA116] hover:text-red-500">Log uit</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endauth
                    @role("medewerker")
                    <li class="w-20">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-[#FEA116] ">beheer <i style="display:none" x-show="!open" class="bi bi-chevron-down"></i> <i style="display:none" x-show="open" class="bi bi-chevron-up"></i></button>
                            <div style="display:none" x-show="open"x-collapse @click.away="open = false" class=" mt-2 w-52 bg-[#0f172b] rounded-md shadow-lg py-1 z-20">
                                    <a class="block px-4 py-2 text-[#FEA116]" href="/admin/reservations">beheer reserveringen</a>
                                @role("admin")
                                    <a class="block px-4 py-2 text-[#FEA116]" href="/admin/users">beheer gebruikers</a>
                                @endrole
                            </div>
                        </div>
                    </li>
                @endrole
            <a href="/#Reserveer" class="btn btn-primary py-2 px-4">Reserveer een tafel</a>
        </div>
    </div>

    {{-- menu --}}
    <div class="gap-2">
        <div class="hidden lg:flex gap-5">
            <ul class="flex gap-3 pt-3">
                <li class=""><a href="/">Home</a></li>
                <li class="w-16"><a href="/over-ons" >Over ons</a></li>
                <li class=""><a href="/menu" class="">Menu</a></li>
                <li class=""><a href="/recenties" class="">Recenties</a></li>
                @auth
                <li class="w-20">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-[#FEA116] ">Account <i style="display:none" x-show="!open" class="bi bi-chevron-down"></i> <i style="display:none" x-show="open" class="bi bi-chevron-up"></i></button>
                            <div style="display:none" x-show="open"x-collapse @click.away="open = false" class="absolute left-1 right-0 mt-2 w-48 bg-[#0f172b] rounded-md shadow-lg py-1 z-20">
                                <a href="/profile" class="block px-4 py-2 text-[#FEA116]">Profiel</a>
                                <form method="post" action="/logout" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 pt-2 text-[#FEA116] hover:text-red-500">Log uit</button>
                                </form>
                            </div>
                        </div>
                    </li>
                    @endauth
                    @role("medewerker")
                    <li class="w-20">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-[#FEA116] ">beheer <i style="display:none" x-show="!open" class="bi bi-chevron-down"></i> <i style="display:none" x-show="open" class="bi bi-chevron-up"></i></button>
                            <div style="display:none" x-show="open"x-collapse @click.away="open = false" class="absolute left-1 top-8 right-0 mt-2 w-52 bg-[#0f172b] rounded-md shadow-lg py-1 z-20">
                                    <a class="block px-4 py-2 text-[#FEA116]" href="/admin/reservations">beheer reserveringen</a>
                                @role("admin")
                                    <a class="block px-4 py-2 text-[#FEA116]" href="/admin/users">beheer gebruikers</a>
                                @endrole
                            </div>
                        </div>
                    </li>
                @endrole
            </ul>
            <a href="/#Reserveer" class="btn btn-primary py-sm-3 px-3 me-3 animated slideInLeft">Reserveer</a>
        </div>
    </div>
</nav>


{{--   --}}
