<div class="mt-20 p-4 flex gap-10 justify-center">
    <div class="mt-10 ml-5">
        <a href="/profile"class="" ><i class=" fa fa-3x fa-arrow-left"></i></a>
    </div>
    <div class="bg-white flex flex-col w-3/4 lg:w-1/5 gap-5 p-4 bg-no-repeat bg-cover shadow bg-[url('https://img.freepik.com/free-photo/white-crumpled-paper-background-simple-diy-craft_53876-128183.jpg?semt=ais_hybrid')]">
        <div>
            <i class="fa fa-utensils me-3"></i>
            Chez Leo
        </div>
        <span>Start datum: {{$bill->reservation->start_time }}</span>
        <span>Eind datum: {{$bill->reservation->end_time}}</span>
        @foreach($bill->products as $product)
            <div class="flex justify-between">
                <span class="">{{$product->dish_name}} {{ $product->pivot->quantity }}x {{$product->price}}</span>
                <span class="">€ {{ number_format($product->pivot->quantity * $product->price,2) }}</span>
            </div>
        @endforeach
        <hr>
        <div class="flex justify-between">
            <span>Totaal:</span>
            <span>€ {{ $bill->getSum() }}</span>
        </div>
    </div>

</div>
