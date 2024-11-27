<div class="mt-20 p-4 flex flex-col lg:flex-row gap-2 lg:gap-10 items-center lg:items-start lg:justify-center">
    <div class="rounded-full flex justify-center items-center p-2 bg-[#11172b] shadow">
        <a href="/profile" wire:navigate class=""><i class=" fa fa-3x fa-arrow-left"></i></a>
    </div>
    <div
        class="bg-white flex flex-col w-3/4 lg:w-fit gap-5 p-4 bg-no-repeat bg-cover shadow bg-[url('https://img.freepik.com/free-photo/white-crumpled-paper-background-simple-diy-craft_53876-128183.jpg?semt=ais_hybrid')]">
        <div>
            <i class="fa fa-utensils me-3"></i>
            Chez Leo
        </div>
        <div class="flex justify-between gap-5">
            <span>Start datum:</span>
            <span>{{$bill->reservation->start_time }}</span>
        </div>
        <div class="flex justify-between gap-5">
            <span>Eind datum:</span>
            <span>{{$bill->reservation->end_time}}</span>
        </div>
        @foreach($bill->products as $product)
            <div class="flex justify-between gap-5">
                <span class="">{{$product->dish_name}} {{ $product->pivot->quantity }}x €{{$product->price}}</span>
                <span class="">€ {{ number_format($product->pivot->quantity * $product->price, 2) }}</span>
            </div>
        @endforeach
        <hr>
        <div class="flex justify-between">
            <span>Totaal:</span>
            <span>€ {{ $bill->getSum() }}</span>
        </div>
    </div>

</div>