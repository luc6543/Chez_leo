<div class="mt-16 mb-5 min-w-screen min-h-screen" wire:poll.500ms="refresh">
    @if($groupedReservations->isEmpty())
        <div class="text-center w-full py-10">
            <p class="text-lg font-semibold">Er zijn geen tafels blijkbaar.</p>
        </div>
    @else
        <div class="overflow-y-scroll w-full min-w-screen flex flex-wrap justify-start gap-5 p-4">
            @foreach($groupedReservations as $group)
                @php $reservation = $group['reservation']; @endphp
                <div wire:click.prevent="createBill({{$group['tables'][0]->id}})" class="w-1/3 cursor-pointer lg:w-1/12 @if($reservation) bg-emerald-800 text-white @else bg-red-900 @endif rounded p-4 shadow flex flex-col justify-center items-center">
                    @if($reservation)
                        <span>Reservation</span>
                        <span>{{ $reservation->id }}</span>
                        @if($reservation->user)
                            <span>{{ $reservation->user->name }}</span>
                        @endif
                        <span>€ {{ $reservation->bill->getSum() }}</span>
                        <div class="mt-2 text-sm">
                            @foreach($group['tables'] as $table)
                                <span>Tafel {{ $table->table_number }}</span><br>
                            @endforeach
                        </div>
                    @else
                        @foreach($group['tables'] as $table)
                            <a wire:click="createBill({{ $table->id }})" class="cursor-pointer">
                                <span>Tafel {{ $table->table_number }}</span>
                            </a>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
