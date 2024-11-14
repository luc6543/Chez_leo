<div lang="en" x-data="{videoModal: false}">
    <div class="fixed flex justify-center items-center w-screen h-screen left-0 top-0 bg-black/75 z-30"
         x-show="videoModal" >
        <div class="bg-white p-10 rounded flex flex-col gap-5" @click.away="videoModal = false">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/uHgt8giw1LY?si=cNeC4LSzLKPzw3oF&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>

    <meta charset="utf-8">
        <title>Restaurant - Chez Leo Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">
    <div class="bg-white p-0">
        {{-- <!-- Spinner Start -->--}}
        <div wire:loading.flex class="bg-black/75 inset-0 fixed flex items-center justify-center transition-opacity duration-500 ease-out delay-500 z-[99999]">
            <div class="border-4 border-yellow-500 border-t-transparent rounded-full w-12 h-12 animate-spin" role="status">
                <span class="sr-only">Laden...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="position-relative p-0">
            <div class="py-5 bg-dark hero-header mb-5">
                <div class="container my-5 py-5">
                    <div class="row align-items-center g-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="display-3 text-white animated slideInLeft">Geniet van onze<br>Heerlijke maaltijd</h1>
                            <p class="text-white animated slideInLeft mb-4 pb-2">Ontdek de smaakvolle gerechten die met zorg en passie zijn bereid. Laat je verrassen door de rijke en authentieke smaken, waarbij ieder hapje een klein moment van geluk biedt. Proef de unieke combinaties en geniet van de warme sfeer die wij voor je hebben gecreëerd. Wij nodigen je uit om samen met ons te genieten van een onvergetelijke culinaire ervaring, waar elke maaltijd een feest is.</p>
                            <button class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Reserveer een tafel</button>
                        </div>
                        <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                            <img class="img-fluid" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Service Start -->
        <div class="  py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                                <h5>Meester Chefs</h5>
                                <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                                <h5>Goede kwaliteit</h5>
                                <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                                <h5>Bestel online</h5>
                                <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="service-item rounded pt-3">
                            <div class="p-4">
                                <i class="fa fa-3x fa-headset text-primary mb-4"></i>
                                <h5>24/7 Service</h5>
                                <p>Diam elitr kasd sed at elitr sed ipsum justo dolor sed clita amet diam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- About Start -->
        <div class="  py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s"
                                     src="img/about-1.jpg">
                            </div>
                            <div class="col-6 text-start">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.3s"
                                     src="img/about-2.jpg" style="margin-top: 25%;">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-75 wow zoomIn" data-wow-delay="0.5s"
                                     src="img/about-3.jpg">
                            </div>
                            <div class="col-6 text-end">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.7s"
                                     src="img/about-4.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Over ons</h5>
                        <h1 class="mb-4">Welkom bij <i class="fa fa-utensils text-primary me-2"></i> Chez Leo</h1>
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                            diam et eos erat ipsum et lorem et sit, sed stet lorem sit.</p>
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet
                            diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna
                            dolore erat amet</p>
                        <div class="row g-4 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">15
                                    </h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Jaar aan</p>
                                        <h6 class="text-uppercase mb-0">Ervaring</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center border-start border-5 border-primary px-3">
                                    <h1 class="flex-shrink-0 display-5 text-primary mb-0" data-toggle="counter-up">50
                                    </h1>
                                    <div class="ps-4">
                                        <p class="mb-0">Populaire</p>
                                        <h6 class="text-uppercase mb-0">Meester Chefs</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="/over-ons" class="btn btn-primary py-3 px-5 mt-2" href="">Lees Meer</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


    <!-- Menu Start -->
    <div class="  py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Ons</h5>
                <h1 class="mb-5">Menu</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li wire:click="filter('Lunch')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 @if($category == "Lunch")active
                         @endif"
                           data-bs-toggle="pill"
                           href="#tab-1">
                            <i class="fa fa-bread-slice fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Onze</small>
                                <h6 class="mt-n1 mb-0">Lunch gerechten</h6>
                            </div>
                        </a>
                    </li>
                    <li wire:click="filter('Diner')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3 @if($category == "Diner")active
                         @endif" data-bs-toggle="pill"
                           href="#tab-2">
                            <i class="fa fa-hamburger fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Heerlijke</small>
                                <h6 class="mt-n1 mb-0">Diner</h6>
                            </div>
                        </a>
                    </li>
                    <li wire:click="filter('Dessert')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3 @if($category == "Dessert")active
                         @endif" data-bs-toggle="pill"
                           href="#tab-3">
                            <i class="fa fa-ice-cream fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Smakelijke</small>
                                <h6 class="mt-n1 mb-0">Dessert</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            @foreach($products as $product)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">
                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>{{$product->dish_name}}</span>
                                            <span class="text-primary">€{{$product->price}}</span>
                                        </h5>
                                        <small class="fst-italic">{{$product->description}}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->


        <!-- Reservation Start -->
        <div class="py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="video">
                        <button type="button" class="btn-play" @click="videoModal = true"
                                data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 bg-dark d-flex align-items-center">
                    <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Reserveren</h5>
                        <h1 class="text-white mb-4">Reserveer Een Tafel Online</h1>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="Uw Naam">
                                        <label for="name">Uw Naam</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="Uw Email">
                                        <label for="email">Uw Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating date" id="date3" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="datetime"
                                               placeholder="Datum & Tijd" data-target="#date3"
                                               data-toggle="datetimepicker" />
                                        <label for="datetime">Datum & Tijd</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="select1">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                        <label for="select1">Aantal Personen</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                            <textarea class="form-control" placeholder="Speciale Verzoeken" id="message"
                                                      style="height: 100px"></textarea>
                                        <label for="message">Speciale Verzoeken</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Reserveer Nu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Reservation Start -->


    <!-- Testimonial Start -->
    <div class="  py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Recenties</h5>
                <h1 class="mb-5">Onze Klanten Zeggen!!!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-1.jpg"
                             style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h5 class="mb-1">Klant Naam</h5>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-2.jpg"
                             style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h5 class="mb-1">Klant Naam</h5>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-3.jpg"
                             style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h5 class="mb-1">Klant Naam</h5>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded p-4">
                    <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos labore
                        diam</p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="img/testimonial-4.jpg"
                             style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h5 class="mb-1">Klant Naam</h5>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Bedrijf</h4>
                    <a class="btn btn-link" href="">Over Ons</a>
                    <a class="btn btn-link" href="">Neem Contact Op</a>
                    <a class="btn btn-link" href="">Reserveren</a>
                    <a class="btn btn-link" href="">Privacybeleid</a>
                    <a class="btn btn-link" href="">Algemene voorwaarden</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>EenStraat 109, 3651 EenPlek, Nederland</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+31 06 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@emailadres.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Openingstijden</h4>
                    <h5 class="text-light fw-normal">Maandag - Zaterdag</h5>
                    <p>09AM - 09PM</p>
                    <h5 class="text-light fw-normal">Zondag</h5>
                    <p>10AM - 08PM</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Nieuwsbrief</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text"
                               placeholder="Uw email">
                        <button type="button"
                                class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Inschrijven</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>
</body>

</div>
