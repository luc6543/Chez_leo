@php
    use Carbon\Carbon;
@endphp

<div class="mt-28">
    <div class="mx-4">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">
                {{ $date_time ? 'Tafels en reserveringen voor de gekozen datum:' : 'Tafels en reserveringen voor vandaag' }}
            </h1>
            <input type="datetime-local" wire:model.live.debounce.20ms="date_time"
                class="block w-1/3 rounded-md border-gray-300">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if($tables->isEmpty() || $reservations->isEmpty())
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold">Geen reserveringen voor deze dag</h2>
                </div>
            @else
                    @foreach($tables as $table)
                            @php
                                $tableReservations = $table->reservations->filter(function ($reservation) use ($date_time) {
                                    $date = Carbon::parse($date_time)->format('Y-m-d');
                                    return Carbon::parse($reservation->start_time)->format('Y-m-d') <= $date &&
                                        Carbon::parse($reservation->end_time)->format('Y-m-d') >= $date;
                                });
                            @endphp
                            @if($tableReservations->isNotEmpty())
                                <div class="bg-white p-4 rounded shadow">
                                    <h2 class="text-xl font-semibold">Tafel {{ $table->table_number }}</h2>
                                    <p>{{ $table->chairs }} stoelen</p>
                                    <ul>
                                        @foreach($tableReservations as $reservation)
                                            <h3 class="text-lg font-semibold mt-2">Reservering {{ $reservation->id }}</h3>
                                            <li>
                                                <p>Van {{ Carbon::parse($reservation->start_time)->format('H:i') }} tot
                                                    {{ Carbon::parse($reservation->end_time)->format('H:i') }}
                                                </p>
                                                @if ($reservation->user || $reservation->guest_name)
                                                    <p>Klant: {{ $reservation->user->name ?? $reservation->guest_name }}</p>
                                                @endif
                                                <p>{{ $reservation->people }}
                                                    {{ $reservation->people == 1 ? 'persoon' : 'personen' }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    @endforeach
            @endif
        </div>
    </div>
</div>