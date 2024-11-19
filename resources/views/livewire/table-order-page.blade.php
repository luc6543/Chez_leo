<div class="mt-20 mb-5 min-w-screen min-h-screen">
    @if (session()->has('userMessage'))
        <div class="fixed z-50 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
            <div class="alert alert-success p-4 mt-10">
                {{ session('userMessage') }}
            </div>
        </div>
    @endif
    <div class="overflow-y-scroll w-full h-full flex flex-col gap-10 items-start justify-start">
        <div class="mt-10 ml-5 w-[50%]">
            <a href="/admin/order"class="" ><i class=" fa fa-3x fa-arrow-left"></i></a>
        </div>
        @foreach($this->products as $category => $products)
            <div x-data="{openMenu : false}" class="w-full">
                <div @click="openMenu = !openMenu" class="bg-white flex justify-between cursor-pointer w-full shadow p-4 rounded ">
                    <span class="select-none">{{$category}}</span>
                    <i x-show="!openMenu" class="bi bi-chevron-down" style="display:none;"></i>
                    <i x-show="openMenu" class="bi bi-chevron-up" style="display:none;"></i>
                </div>
                <div class="flex shadow rounded flex-wrap gap-5 justify-around w-full h-fit" x-show="openMenu" style="display:none;">
                    @foreach($products as $product)
                        <div class="w-full mx-4 bg-white rounded shadow mt-2 mb-8">
                            {{-- w-1/3 bg-slate-700 p-2 gap-5 shadow rounded text-white flex flex-col --}}
                            <span class="pl-4">{{$product["dish_name"]}}</span>
                            <hr>
                            <span class="pl-[40%]">€ {{$product["price"]}}</span>
                            <hr>
                            <div class="flex justify-between">
                                <button wire:click="removeQuantity({{$product['id']}})" class="p-3 mx-2 rounded text-white shadow bg-red-500">-</button>
                                <span>{{ $quantities[$product['id']] }}</span>
                                <button wire:click="addQuantity({{$product['id']}})" class="p-3 mx-2 rounded shadow text-white bg-green-500">+</button>
                            </div>
                            <button class="rounded w-[95%] m-2 p-2 text-center shadow bg-white hover:text-gray-800 text-[#FEA116]" wire:click="orderProduct({{$product['id']}})">Bestellen</button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <button wire:click.prevent="billPaid" class="w-full p-2 bg-green-500 shadow px-4 text-white">Rekening betaald</button>
    </div>
</div>
