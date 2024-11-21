<div class="mt-16 mb-5 min-w-screen min-h-screen" wire:poll.500ms="refresh">
    @if($reservations->isEmpty())
        <div class="text-center w-full py-10">
            <p class="text-lg font-semibold">Geen actieve reserveringen gevonden voor vandaag.</p>
        </div>
    @else
        <div class="overflow-y-scroll w-full min-w-screen flex flex-wrap justify-start gap-5 p-4">
            @foreach($reservations as $reservation)
                <a href="/admin/reservation/{{$reservation->id}}" class="w-1/3 lg:w-1/12 bg-red-900 rounded p-4 shadow flex flex-col justify-center items-center">
                    <span>Tafel</span>
                    <span>{{ $reservation->table->table_number }}</span>
                    <span>{{ $reservation->user->name }}</span>
                    <span>€ {{ $reservation->bill->getSum() }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>
