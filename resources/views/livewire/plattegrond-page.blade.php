<div class="mt-24">
    <div class="ml-6 flex justify-center">
        <div class="flex space-x-1 rounded-lg bg-slate-100 p-0.5">
            <button wire:click="changeMode('figma')" class="flex items-center rounded-md py-[0.4375rem] pl-2 pr-2 @if($mode == 'figma') bg-white @endif text-sm font-semibold lg:pr-3" id="headlessui-tabs-tab-:r8s:" role="tab" type="button" aria-selected="false" tabindex="-1">
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-800">Getekend</span>
            </button>
            <button wire:click="changeMode('minecraft')" class="flex items-center rounded-md py-[0.4375rem] pl-2 pr-2 text-sm font-semibold lg:pr-3 @if($mode == 'minecraft') bg-white @endif " id="headlessui-tabs-tab-:r8q:" role="tab" type="button" aria-selected="true" tabindex="0">
                <span class="sr-only lg:not-sr-only lg:ml-2 text-slate-800">Live</span>
            </button>
        </div>
    </div>
    @if($mode == 'minecraft')
    <img class="size-full" src="img/minecraft_plattegrond.gif" alt="">
    @endif
    @if($mode == 'figma')
    <img class="size-full" src="img/figma_plattegrond.png" alt="">
    @endif
</div>