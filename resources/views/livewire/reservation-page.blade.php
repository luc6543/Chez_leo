@php
    use Carbon\Carbon;
@endphp

<div>
    <div class="bg-gray-900 py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-base font-semibold text-white">Reservations</h1>
                <button wire:click="openModal"
                    class="bg-yellow-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-yellow-400">
                    Voeg reservation toe
                </button>
            </div>

            <table class="min-w-full divide-y divide-gray-700 mt-8">
                <thead>
                    <tr>
                        <th class="py-3.5 text-left text-sm font-semibold text-white">ID</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Klant</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Tafelnummer</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Start datum en tijd</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Eind datum en tijd</th>
                        <th class="py-3.5"></th>
                        <th class="py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach ($reservations as $reservation)
                        @if ($reservation->user != null && $reservation->table != null)
                            <tr>
                                <td class="py-4 text-sm text-white">{{ $reservation->id }}</td>
                                <td class="px-3 py-4 text-sm text-gray-300">{{ $reservation->user->name }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-300">{{ $reservation->table->table_number }}</td>
                                <td class="px-3 py-4 text-sm text-gray-300">
                                    {{ Carbon::parse($reservation->start_time)->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-300">
                                    {{ Carbon::parse($reservation->end_time)->format('Y-m-d H:i') }}
                                </td>
                                <td class="text-right">
                                    <button wire:click="edit({{ $reservation->id }})"
                                        class="bg-blue-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-blue-400">Verander</button>
                                </td>
                                <td class="text-right">
                                    <button wire:click="delete({{ $reservation->id }})"
                                        class="bg-red-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-red-400">Verwijder</button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-lg font-semibold mb-4">
                    {{ $reservationId ? 'Edit Reservation' : 'Create Reservation' }}
                </h2>

                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Klant</label>
                        <select wire:model.defer="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Selecteer een klant</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->id }}: {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tafel</label>
                        <select wire:model.defer="table_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Selecteer een tafel</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Tafelnummer: {{ $table->table_number }}</option>
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