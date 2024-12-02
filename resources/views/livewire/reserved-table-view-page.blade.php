@php
    use Carbon\Carbon;
@endphp

<div class="mt-28">
    <div class="mx-4">

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">
                {{ $date_time ? 'Tafels en reserveringen voor de gekozen datum:' : 'Tafels en reserveringen voor vandaag' }}
            </h1>
            <input type="date" wire:model.live.debounce.20ms="date_time" class="block w-1/3 rounded-md border-gray-300">
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
                                })->sortBy('start_time');
                            @endphp
                            @if($tableReservations->isNotEmpty())
                                <div class="bg-white p-4 rounded shadow">
                                    <h2 class="text-xl font-semibold">Tafel {{ $table->table_number }}</h2>
                                    <p>{{ $table->chairs }} stoelen</p>
                                    <div class="grid grid-cols-2 items-center relative">
                                        @foreach($tableReservations as $reservation)
                                            <div class="relative flex flex-col items-center justify-center {{ in_array($loop->iteration, [2, 4]) ? 'border-l-2 border-gray-500 h-2/3' : '' }}">
                                                <!-- Reservation Content -->
                                                <div class="text-center w-3/4 pt-2 {{ in_array($loop->iteration, [3, 4, 5]) ? 'border-t-2 border-gray-500' : '' }}">
                                                    <p class="text-lg font-semibold">
                                                        {{ Carbon::parse($reservation->start_time)->format('H:i') }} -
                                                        {{ Carbon::parse($reservation->end_time)->format('H:i') }}</p>
                                                    @if ($reservation->user || $reservation->guest_name)
                                                        <p>{{ $reservation->user->name ?? $reservation->guest_name }}</p>
                                                    @endif
                                                    <p>{{ $reservation->people }} {{ $reservation->people == 1 ? 'persoon' : 'personen' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                    @endforeach
            @endif
        </div>
    </div>
</div>