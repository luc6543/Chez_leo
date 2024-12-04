<div class="mt-20 mb-5 min-w-screen min-h-screen" x-data="{ confirmationModal : false, showUserMessage: {{ session()->has('userMessage') ? 'true' : 'false' }} }">
    <div class="fixed bg-black/75 top-0 left-0 z-50 w-screen h-screen flex justify-center items-center"
         x-cloak x-show="confirmationModal">
        <div class="p-6 shadow bg-white flex flex-col gap-5"
             @click.away="confirmationModal = false">
            <h1>Betaling succesvol?</h1>
            <div class="w-full flex justify-around items-center">
                <button
                    onclick="this.disabled=true; setTimeout(() => { this.disabled=false; }, 1000);"
                    wire:click="billPaid"
                    class="p-2 px-4 rounded shadow bg-red-500 text-white">Ja</button>
                <button @click="confirmationModal = false"
                        class="p-2 px-4 rounded shadow bg-indigo-500 text-white">Nee</button>
            </div>
        </div>
    </div>

    @if (session()->has('userMessage'))
    <div x-show="showUserMessage" x-init="setTimeout(() => showUserMessage = false, 3000)" class="fixed z-30 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
        <div class="alert alert-success p-4 mt-10">
            {{ session('userMessage') }}
        </div>
    </div>
    @endif
    <div class="w-full h-full flex flex-col gap-10 items-start justify-start">
        <div class="mt-10 ml-5 w-[50%] z-50">
            <a href="/admin/order" wire:navigate><i class=" fa fa-3x fa-arrow-left"></i></a>
        </div>
        @foreach($this->products as $category => $products)
            <div x-data="{openMenu : false}" class="w-full">
                <div @click="openMenu = !openMenu" x-if="openMenu"
                    class="bg-white sticky top-20 flex justify-between cursor-pointer w-full shadow p-4 rounded">
                    <span class="select-none">{{$category}}</span>
                    <i x-show="!openMenu" class="bi bi-chevron-down" style="display:none;"></i>
                    <i x-show="openMenu" class="bi bi-chevron-up" style="display:none;"></i>
                </div>
                <div class="flex shadow rounded bg-white flex-wrap gap-5 justify-around w-full h-fit" x-show="openMenu"
                    x-cloak>
                    @foreach($products as $product)
                        <div class="w-full mx-4 bg-white rounded shadow mt-2 mb-8">
                            <span class="pl-4">{{$product["dish_name"]}}</span>
                            <hr>
                            <div class="flex justify-between">
                                <button wire:click="removeQuantity({{$product['id']}})"
                                    class="p-3 mx-2 rounded text-white shadow bg-red-500">-</button>
                                <span>{{ $quantities[$product['id']] }}</span>
                                <button wire:click="addQuantity({{$product['id']}})"
                                    class="p-3 mx-2 rounded shadow text-white bg-green-500">+</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="bottom-0 fixed left-0 w-screen flex justify-around">
            <button wire:click.prevent="order" class="w-1/3 p-2 bg-green-500 shadow px-4 text-white">Bestellen</button>
            <button @click="confirmationModal = true"
                class="w-1/3 shadow px-4 text-white bg-emerald-800 p-2 rounded">Rekening betaald <span>Totaal
                    ${{ $reservation->bill->getSum() }}</span></button>
        </div>
    </div>
</div>
