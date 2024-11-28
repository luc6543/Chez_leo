<div class="mt-28 bg-white mb-16">
    <div class="ml-6 flex justify-center">
        <div class="flex space-x-1 rounded-lg w-1/3 bg-slate-100 p-4">
            <button wire:click="changeMode('kitchen')" class="flex items-center rounded-md py-[0.4375rem] pl-2 pr-2 text-sm w-full h-full font-semibold lg:pr-3 @if($mode == 'kitchen') bg-white @endif " id="headlessui-tabs-tab-:r8q:" role="tab" type="button" aria-selected="true" tabindex="0">
                <i class="fa fa-utensils me-3"></i><span class="sr-only lg:not-sr-only lg:ml-2 text-slate-900">Keuken</span>
            </button>
            <button wire:click="changeMode('bar')" class="flex w-full h-full items-center rounded-md py-[0.4375rem] pl-2 pr-2 @if($mode == 'bar') bg-white @endif text-sm font-semibold lg:pr-3" id="headlessui-tabs-tab-:r8s:" role="tab" type="button" aria-selected="false" tabindex="-1">
                <i class="fa fa-wine-glass"></i>
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-600">Bar</span>
            </button>
            <button wire:click="toggleCompleted" class="rounded-md py-[0.4375rem] w-full h-full @if($showCompleted) bg-white text-black @endif">Laat complete zien.</button>
        </div>
    </div>

    <div class="flex flex-wrap">
        @foreach($products as $tableNumber => $tableProducts)
            <div class="w-full lg:w-fit xl:w-1/3 p-2">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <h2 class="text-xl font-semibold">Tafel {{ $tableNumber }}</h2>
                    <div class="mt-2 flex flex-wrap justify-around gap-10">
                        @foreach($tableProducts as $product)
                            <div wire:click="complete({{ $product->pivot->id }})" class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif cursor-pointer shadow w-1/3 h-1/2 rounded-lg p-6 my-1">
                                <div class="flex justify-between">
                                    <span class="font-medium w-fit">{{ $product->dish_name }}</span>
                                    <span class="font-medium">x{{ $product->pivot->quantity }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
