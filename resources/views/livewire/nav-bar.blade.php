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
    <div x-show="navBarShown" x-collapse id="navbarCollapse">
        <div class="lg:hidden flex-col pl-0 mb-0 list-none flex ms-auto w-fit py-0 pe-4">
            <a href="/">Home</a>
            <a href="/over-ons">Over ons</a>
            <a href="#">Menu</a>
            <a href="#">Recenties</a>
            @auth
            <form method="post" action="/logout">
                @csrf
                <button type="submit" class="p-2 px-4 bg-gray-800 rounded hover:bg-red-500 text-white">Logout</button>
            </form>
            @endauth
            <button class="btn btn-primary py-2 px-4">Reserveer een tafel</button>
        </div>
    </div>

    {{-- menu --}}
    <div class="gap-2">
        <div class="hidden lg:flex gap-5">
            <ul class="flex gap-3 pt-3">
                <li class=""><a href="/">Home</a></li>
                <li class="w-16"><a href="/over-ons" >Over ons</a></li>
                <li class=""><a href="#" class="">Menu</a></li>
                <li class=""><a href="#" class="">Recenties</a></li>
                @auth
                <form method="post" action="/logout">
                    @csrf
                    <button type="submit" class="p-2 px-4 bg-gray-800 rounded hover:bg-red-500 text-white">Log uit</button>
                </form>
                @endauth
            </ul>
            <button class="btn btn-primary py-2 px-4">Reserveer een tafel</button>
        </div>
    </div>
</nav>
