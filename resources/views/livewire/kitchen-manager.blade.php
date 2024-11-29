<div class="mt-28 bg-white mb-16">
    <div class="ml-6 flex justify-center">
        <div class="flex space-x-1 rounded-lg w-full sm:w-1/2 lg:w-1/3 bg-slate-100 p-2">
            <button wire:click="changeMode('kitchen')" class="flex items-center pl-8 rounded-md py-[0.4375rem]
            pr-2 text-sm w-full h-full font-semibold lg:pr-3 @if($mode == 'kitchen') bg-white @endif" id="headlessui-tabs-tab-:r8q:" role="tab" type="button" aria-selected="true" tabindex="0">
                <i class="fa fa-utensils me-3"></i><span class="sr-only lg:not-sr-only lg:ml-2 text-slate-900">Keuken</span>
            </button>
            <button wire:click="changeMode('bar')" class="flex w-full h-28 items-center rounded-md py-[0.4375rem] pl-2 pr-2 @if($mode == 'bar') bg-white @endif text-sm justify-center font-semibold lg:pr-3"
                    id="headlessui-tabs-tab-:r8s:" role="tab" type="button" aria-selected="false" tabindex="-1">
                <i class="fa fa-wine-glass"></i>
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-600">Bar</span>
            </button>
            <button wire:click="changeMode('all')" class="flex gap-1 w-full h-28 items-center rounded-md py-[0.4375rem] pl-2 pr-2 @if($mode == 'all') bg-white @endif text-sm justify-center font-semibold lg:pr-3"
                    id="headlessui-tabs-tab-:r8s:" role="tab" type="button" aria-selected="false" tabindex="-1">
                <i class="fa fa-wine-glass"></i>
                <i class="fa fa-utensils me-3"></i>
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-600">Alle</span>
            </button>
            <button wire:click="toggleCompleted" class="rounded-md py-[0.4375rem] w-full h-full @if($showCompleted) bg-white text-black @endif">Laat complete zien.</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4 auto-rows-min">
        @foreach($products as $tableNumber => $tableProducts)
            <div class="bg-white shadow-lg rounded-lg p-4 flex flex-col w-full">
                <h2 class="text-lg sm:text-xl font-semibold">Tafel {{ $tableNumber }}</h2>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-min">
                    @if( $tableProducts->has('Drank') )
                        @foreach($tableProducts['Drank'] as $product)
                            <div wire:click="complete({{ $product->pivot->id }})" class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif w-fit cursor-pointer shadow rounded-lg p-6" style="grid-column: span {{ $product->colSpan ?? 1 }};grid-row: span {{ $product->rowSpan ?? 1 }};">
                                <div class="flex justify-between gap-2">
                                    <span class="font-medium">{{ $product->dish_name }}</span>
                                    <span class="font-medium">x{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-min">
                    @if( $tableProducts->has('Diner') )
                        @foreach($tableProducts['Diner'] as $product)
                            <div wire:click="complete({{ $product->pivot->id }})" class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif w-fit cursor-pointer shadow rounded-lg p-6" style="grid-column: span {{ $product->colSpan ?? 1 }};grid-row: span {{ $product->rowSpan ?? 1 }};">
                                <div class="flex justify-between gap-2">
                                    <span class="font-medium">{{ $product->dish_name }}</span>
                                    <span class="font-medium">x{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @if($tableProducts->has('Lunch'))
                        @foreach($tableProducts['lunch'] as $product)
                            <div wire:click="complete({{ $product->pivot->id }})" class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif w-fit cursor-pointer shadow rounded-lg p-6" style="grid-column: span {{ $product->colSpan ?? 1 }};grid-row: span {{ $product->rowSpan ?? 1 }};">
                                <div class="flex justify-between gap-2">
                                    <span class="font-medium">{{ $product->dish_name }}</span>
                                    <span class="font-medium">x{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <hr>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 auto-rows-min">
                        @if($tableProducts->has('Dessert'))
                            @foreach($tableProducts['Dessert'] as $product)
                                <div wire:click="complete({{ $product->pivot->id }})" class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif w-fit cursor-pointer shadow rounded-lg p-6" style="grid-column: span {{ $product->colSpan ?? 1 }};grid-row: span {{ $product->rowSpan ?? 1 }};">
                                    <div class="flex justify-between gap-2">
                                        <span class="font-medium">{{ $product->dish_name }}</span>
                                        <span class="font-medium">x{{ $product->pivot->quantity }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
