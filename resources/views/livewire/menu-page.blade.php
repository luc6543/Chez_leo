<div class="bg-stone-800 text-white w-full h-fit">
    @push('styles')
        <meta charset="utf-8">
        <title>Chez Leo | Menu</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Favicon -->
        <link href="{{ asset('img/favicon.ico') }}" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap"
              rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @endpush
    <!-- Menu Start -->
    <div class="p-6 py-40 text-white lg:hidden">
        <div class="container">
            <div class="text-center wow fadeInUp">
                <h5 class="section-title text-white text-center fw-normal">Ons</h5>
                <h1 class="mb-5 text-white">Menu</h1>
            </div>
            <div class="tab-class text-center wow fadeInUp">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li wire:click="filter('Lunch')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 @if($category == "Lunch")active
                         @endif" href="#">
                            <i class="fa fa-bread-slice fa-2x "></i>
                            <div class="ps-3">
                                <small class="text-body text-white">Onze</small>
                                <h6 class="mt-n1 mb-0 text-white">Lunch gerechten</h6>
                            </div>
                        </a>
                    </li>
                    <li wire:click="filter('Diner')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3 @if($category == "Diner")active
                         @endif" href="#">
                            <i class="fa fa-hamburger fa-2x "></i>
                            <div class="ps-3">
                                <small class="text-body">Heerlijke</small>
                                <h6 class="mt-n1 mb-0 text-white">Diner</h6>
                            </div>
                        </a>
                    </li>
                    <li wire:click="filter('Dessert')" class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3 @if($category == "Dessert")active
                         @endif" href="#">
                            <i class="fa fa-ice-cream fa-2x "></i>
                            <div class="ps-3">
                                <small class="text-body">Smakelijke</small>
                                <h6 class="mt-n1 mb-0 text-white">Dessert</h6>
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
                                                <span class="text-white">{{$product->dish_name}}</span>
                                                <span class="text-white">€{{$product->price}}</span>
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

        <div class="p-6 py-40 text-white hidden lg:block">
            <div class="container">
                <div class="text-center wow fadeInUp">
                    <h5 class="section-title text-white text-center fw-normal">Ons</h5>
                    <h1 class="mb-5 text-white">Menu</h1>
                </div>
                    <div class="flex flex-row gap-5 w-full justify-around items-center">
                        <div class="tab-content flex flex-col flex-grow">
                            <div class="d-flex align-items-center text-start mx-3 pb-3">
                                <i class="fa fa-bread-slice fa-2x "></i>
                                <div class="ps-3">
                                    <small class="text-body text-white">Onze</small>
                                    <h6 class="mt-n1 mb-0 text-white">Lunch gerechten</h6>
                                </div>
                            </div>
                            @foreach($lunch as $product)
                                <div class="w-full px-4 p-2">
                                    <div class="flex items-center">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span class="text-white">{{$product->dish_name}}</span>
                                                <span class="text-white">€{{$product->price}}</span>
                                            </h5>
                                            <small class="fst-italic">{{$product->description}}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-content flex flex-col flex-grow">
                            <div class="d-flex align-items-center text-start mx-3 pb-3">
                                <i class="fa fa-hamburger fa-2x"></i>
                                <div class="ps-3">
                                    <small class="text-body text-white">Heerlijke</small>
                                    <h6 class="mt-n1 mb-0 text-white">Diner</h6>
                                </div>
                            </div>
                            @foreach($diner as $product)
                                <div class="w-full px-4 p-2">
                                    <div class="flex items-center">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span class="text-white">{{$product->dish_name}}</span>
                                                <span class="text-white">€{{$product->price}}</span>
                                            </h5>
                                            <small class="fst-italic">{{$product->description}}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-content">
                            <div class="flex items-center text-start mx-3 me-0 pb-3" href="#">
                                <i class="fa fa-ice-cream fa-2x"></i>
                                <div class="ps-3">
                                    <small class="text-body">Smakelijke</small>
                                    <h6 class="mt-n1 mb-0 text-white">Dessert</h6>
                                </div>
                            </div>
                            @foreach($dessert as $product)
                                <div class="w-full px-4 p-2">
                                    <div class="flex items-center">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span class="text-white">{{$product->dish_name}}</span>
                                                <span class="text-white">€{{$product->price}}</span>
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
    <!-- Menu End -->
    @assets
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!-- Other dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Your custom main.js -->
    {{--<script src="/js/main.js"></script>--}}
    @endassets
</div>
