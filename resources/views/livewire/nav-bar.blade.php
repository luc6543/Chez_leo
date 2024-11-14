<nav class="md:items-start !fixed z-10 top-0 left-0 w-screen navbar-expand-lg bg-black/75 lg:bg-black/25 px-4 px-lg-5 py-3 py-lg-3 flex flex-col lg:flex-row" x-data="{navBarShown : false}">
    <div class="flex gap-5 w-full items-center justify-around lg:justify-start">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Chez Leo</h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" @click="navBarShown = !navBarShown">
            <span class="fa fa-bars"></span>
        </button>
    </div>
    <div x-show="navBarShown" x-collapse id="navbarCollapse">
        <div class="navbar-nav ms-auto w-fit py-0 pe-4">
            <a href="index.html" class="nav-item nav-link active">Home</a>
            <a href="about.html" class="nav-item nav-link w-fit">Over ons</a>
            <a href="service.html" class="nav-item nav-link">Service</a>
            <a href="menu.html" class="nav-item nav-link">Menu</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Paginas</a>
                <div class="dropdown-menu m-0">
                    <a href="booking.html" class="dropdown-item">Reserveren</a>
                    <a href="team.html" class="dropdown-item">Ons Team</a>
                    <a href="testimonial.html" class="dropdown-item">Recenties</a>
                </div>
            </div>
            <a href="contact.html" class="nav-item nav-link">Contact</a>
            <button class="btn btn-primary py-2 px-4">Reserveer een tafel</button>
        </div>
    </div>

    <div>
        <div class="hidden lg:flex w-fit gap-2 ms-auto py-0 pe-4">
            <a href="index.html" class="nav-item nav-link active">Home</a>
            <a href="about.html" class="nav-item nav-link w-fit">Over ons</a>
            <a href="service.html" class="nav-item nav-link">Service</a>
            <a href="menu.html" class="nav-item nav-link">Menu</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Paginas</a>
                <div class="dropdown-menu m-0">
                    <a href="booking.html" class="dropdown-item">Reserveren</a>
                    <a href="team.html" class="dropdown-item">Ons Team</a>
                    <a href="testimonial.html" class="dropdown-item">Recenties</a>
                </div>
            </div>
            <a href="/contact" class="nav-item nav-link">Contact</a>
            <button class="btn btn-primary py-2 px-4">Reserveer een tafel</button>
        </div>
    </div>
</nav>
