<div class="mt-28 bg-white mb-16">
    <div class="ml-6 flex justify-center">
        <div class="flex space-x-1 rounded-lg bg-slate-100 p-0.5">
            <button wire:click="changeMode('kitchen')" class="flex items-center rounded-md py-[0.4375rem] pl-2 pr-2 text-sm font-semibold lg:pr-3 @if($mode == 'kitchen') bg-white @endif " id="headlessui-tabs-tab-:r8q:" role="tab" type="button" aria-selected="true" tabindex="0">
                <i class="fa fa-utensils me-3"></i><span class="sr-only lg:not-sr-only lg:ml-2 text-slate-900">Keuken</span>
            </button>
            <button wire:click="changeMode('bar')" class="flex items-center rounded-md py-[0.4375rem] pl-2 pr-2 @if($mode == 'bar') bg-white @endif text-sm font-semibold lg:pr-3" id="headlessui-tabs-tab-:r8s:" role="tab" type="button" aria-selected="false" tabindex="-1">
                <i class="fa fa-wine-glass"></i>
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-600">Bar</span>
            </button>
            <button wire:click="toggleCompleted" class="rounded-md py-[0.4375rem] @if($showCompleted) bg-white text-black @endif">Laat complete zien.</button>
        </div>
    </div>

    <div class="flex flex-wrap">
        @foreach($products as $product)
            <div class="w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2 cursor-pointer" wire:click="complete({{ $product->pivot->id }})">
                <div class="@if($product->pivot->completed) bg-red-300 text-white @else bg-white @endif shadow-lg rounded-lg p-2">
                    <div class="flex justify-between">
                        <h2 class="text-xl font-semibold">{{ $product->dish_name }}</h2>
                        <span class="text-xl font-semibold">X {{ $product->pivot->quantity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-600">Tafel {{ $product->table_number }}</span>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
