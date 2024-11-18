@php
    use Carbon\Carbon;
@endphp

<div>
    <div class="bg-[#0f172b] py-10 mt-16">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-base font-bold text-white">Reservations</h1>

                <button wire:click="toggleShowPastReservations"
                    class="{{ $showPastReservations ? "bg-red-700" : "bg-green-700" }} px-3 py-2 text-sm text-white rounded-md {{ $showPastReservations ? "hover:bg-red-600" : "hover:bg-green-600" }}">
                    {{ $showPastReservations ? 'Verberg verleden reserveringen' : 'Toon verleden reserveringen' }}
                </button>

                <button wire:click="toggleShowNonActiveReservations"
                    class="{{ $showNonActiveReservations ? "bg-red-700" : "bg-green-700" }} px-3 py-2 text-sm text-white rounded-md {{ $showNonActiveReservations ? "hover:bg-red-600" : "hover:bg-green-600" }}">
                    {{ $showNonActiveReservations ? 'Verberg inactieve reserveringen' : 'Toon inactieve reserveringen' }}
                </button>

                <button wire:click="openModal"
                    class="bg-blue-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-blue-600">
                    Voeg reservation toe
                </button>
            </div>

            <table class="min-w-full divide-y divide-gray-700 mt-8">
                <thead>
                    <tr>
                        <th class="py-3.5 text-left text-sm font-semibold text-white">ID</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Klant</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Personen</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Tafelnummer</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Actief</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Start datum en tijd</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Eind datum en tijd</th>
                        <th class="py-3.5"></th>
                        <th class="py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @if ($reservations->isEmpty())
                        <tr>
                            <td class="py-4 text-sm text-white" colspan="9">Geen reserveringen gevonden</td>
                        </tr>
                    @else
                        @foreach ($reservations as $reservation)
                            @if ($reservation != null && $reservation->user != null && $reservation->table != null)
                                <tr>
                                    <td class="py-4 text-sm text-white">{{ $reservation->id }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-300">{{ $reservation->user->name }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-300">{{ $reservation->people }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-300">{{ $reservation->table->table_number }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-300">
                                        {{ $reservation->active ? 'Ja' : 'Niet' }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-300">
                                        {{ Carbon::parse($reservation->start_time)->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-300">
                                        {{ Carbon::parse($reservation->end_time)->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="text-right">
                                        <button wire:click="edit({{ $reservation->id }})"
                                            class="bg-green-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-green-600">Verander</button>
                                    </td>
                                    <td class="text-right">
                                        <button wire:click="delete({{ $reservation->id }})"
                                            class="bg-red-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-red-600">Verwijder</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-lg font-semibold mb-2">
                    {{ $reservationId ? 'Edit Reservation' : 'Create Reservation' }}
                </h2>

                @if (session()->has('error'))
                    <div class="alert alert-danger text-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="store">
                    <div class="mb-4 mt-2">
                        <label class="block text-sm font-medium">Klant</label>
                        <select wire:model.defer="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Selecteer een klant</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->id }}: {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Personen</label>
                        <input wire:model.live.debounce.20ms="people" wire:change="updateTableList" type="number" min="1"
                            max="6" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tafel</label>
                        <select wire:model.defer="table_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Selecteer een tafel</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Tafel {{ $table->table_number }}: {{ $table->chairs }}
                                    {{ $table->chairs == 1 ? 'stoel' : 'stoelen' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Start tijd</label>
                        <input type="datetime-local" wire:model.defer="start_time"
                            class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Actief</label>
                        <input type="checkbox" wire:model.defer="active" class="mt-1 block rounded-md border-gray-300">
                    </div>
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Opslaan</button>
                    <button type="button" wire:click="closeModal"
                        class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Annuleer</button>
                </form>
            </div>
        </div>
    @endif
</div>