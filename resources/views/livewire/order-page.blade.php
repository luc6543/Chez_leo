<div class="mt-16 mb-5 min-w-screen min-h-screen" wire:poll.500ms="refresh">
    @if($tables->isEmpty())
        <div class="text-center w-full py-10">
            <p class="text-lg font-semibold">Er zijn geen tafels blijkbaar.</p>
        </div>
    @else
        <div class="overflow-y-scroll w-full min-w-screen flex flex-wrap justify-start gap-5 p-4">
            @foreach($tables as $table)
                <a wire:click="createBill({{$table->id}})" class="w-1/3 lg:w-1/12 cursor-pointer bg-red-900 rounded p-4 shadow flex flex-col justify-center items-center">
                    <span>Tafel</span>
                    <span>{{ $table->table_number }}</span>
                    @if($table->getCurrentReservation())
                        @if($table->getCurrentReservation()->user)
                            <span>{{ $table->getCurrentReservation()->user->name }}</span>
                        @endif
                            <span>€ {{ $table->getCurrentReservation()->bill->getSum() }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    @endif
</div>
