@php
    use Carbon\Carbon;
@endphp

<div x-data="{modalOpened : false}" @close-modal=" modalOpened = false " @open-modal="modalOpened = true">
    @push('styles')
        @include('flatpickr::components.style')
    @endpush
    @push('scripts')
        @include('flatpickr::components.script')

        <script>
            function handleChange(selectedDates, dateStr, instance) {
                console.log({ selectedDates, dateStr, instance });

                if (!selectedDates.length) return; // If no date is selected, return.

                const selectedDate = selectedDates[0];
                const dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
                let minTime = null;

                switch (dayOfWeek) {
                    case 0: // Sunday
                    case 5: // Friday
                    case 6: // Saturday
                        minTime = "12:00"; // 12 PM
                        break;
                    case 3: // Wednesday
                        minTime = "17:00"; // 5 PM
                        break;
                    case 4: // Thursday
                        minTime = "12:00"; // 12 PM
                        break;
                    default: // Monday and Tuesday (Closed)
                        instance.close(); // Close the calendar for closed days
                        alert("Gesloten (Closed) on this day.");
                        return;
                }

                // Set the new minTime for Flatpickr
                instance.set("minTime", minTime);
                console.log(`Min time set to: ${minTime}`);
            }
        </script>
    @endpush
    <div class="bg-white py-10 mt-16">
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

                <button @click="modalOpened = true"
                    class="bg-blue-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-blue-600">
                    Voeg reservation toe
                </button>
            </div>
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flow-root">
                    <div class="-my-2 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg mt-2">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                ID</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Klant
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Personen</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Tafelnummer</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Actief
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start
                                                datum en tijd</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Eind
                                                datum en tijd</th>
                                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>

                                        </tr>
                                    </thead>
                                    <div class="bg-white">
                                        @foreach($reservations as $reservation)
                                            <tr class="w-full border-gray-200 border-t-2">
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->id }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->user->name ?? 'Geen klant' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->people }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->table->table_number }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->active ? 'Ja' : 'Niet' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ Carbon::parse($reservation->start_time)->format('Y-m-d H:i') }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ Carbon::parse($reservation->end_time)->format('Y-m-d H:i') }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    @if($reservation->special_request != null)
                                                        <button id="chevron-{{ $reservation->id }}"
                                                            class="chevron-button text-black"
                                                            onclick="toggleSpecialRequest({{ $reservation->id }})">
                                                            <svg id="chevron-down-{{ $reservation->id }}"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="size-5 chevron-down hover:text-primary-900 hidden">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                            </svg>
                                                            <svg id="chevron-up-{{ $reservation->id }}"
                                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                class="size-5 chevron-up hover:text-primary-900">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    <button wire:click="edit({{ $reservation->id }})"
                                                        class="bg-green-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-green-600">Verander
                                                    </button>
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    <button wire:click="delete({{ $reservation->id }})"
                                                        x-data="{ isDeleting: false }" @click="isDeleting = true"
                                                        :disabled="isDeleting"
                                                        class="bg-red-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-red-600">Verwijder
                                                    </button>
                                                </td>
                                            </tr>
                                            <td id="td-sr-p-{{ $reservation->id }}" colspan="10" class="pb-4">
                                                <p id="specialRequest-{{ $reservation->id }}"
                                                    class="hidden px-4 py-0 break-all">
                                                    {{ $reservation->special_request }}
                                                </p>
                                            </td>

                                        @endforeach
                                    </div>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="modalOpened" x-cloak
        class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-50">
        <div x-transition class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-lg font-semibold mb-2">
                {{ $reservationId ? 'Edit Reservation' : 'Create Reservation' }}
            </h2>

            <form wire:submit.prevent="store">
                <div class="mb-4 mt-2">
                    <label class="block text-sm font-medium">Klant</label>
                    <div class="flex items-center justify-between">
                        <select id="user-select" wire:model.defer="user_id"
                            class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Selecteer een klant</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->id }}: {{ $user->name }}</option>
                            @endforeach
                        </select>

                        <input wire:model.defer="guest_name" id="guest-name"
                            class="mt-1 w-full rounded-md border-gray-300 hidden"
                            placeholder="Type de naam van de klant">

                        <button type="button" onclick="toggleGuestInput()" class="ml-4 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </button>
                    </div>

                    <script>
                        function toggleGuestInput() {
                            const userSelect = document.getElementById('user-select');
                            const guestName = document.getElementById('guest-name');

                            if (guestName.classList.contains('hidden')) {
                                guestName.classList.remove('hidden');
                                userSelect.classList.add('hidden');
                            } else {
                                guestName.classList.add('hidden');
                                userSelect.classList.remove('hidden');
                            }
                        }
                    </script>

                    @error('user_id')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <x-flatpickr id="flatPickr" value="{{$start_time}}" max-time="20:30" clearable
                        onChange="handleChange" :disable="['monday', 'tuesday']" class="h-full" date-format="d-m-Y"
                        placeholder="Datum & Tijd" :min-date="today()" wire:model="start_time" show-time />
                    @error('start_time')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Personen</label>
                    <input wire:model.live.debounce.20ms="people" wire:change="updateTableList" type="number" min="1"
                        max="6" class="mt-1 block w-full rounded-md border-gray-300">
                    @error('people')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
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
                    @error('table_id')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Speciaal verzoek</label>
                    <textarea maxlength="255" wire:model.defer="special_request"
                        class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                    @error('special_request')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium">Actief</label>
                    <input type="checkbox" wire:model.defer="active" class="mt-1 block rounded-md border-gray-300">
                    @error('active')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Opslaan</button>
                <button type="button" @click="modalOpened = false" wire:click="resetInputFields"
                    class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Annuleer</button>
            </form>
        </div>
    </div>
</div>


<script>
    function toggleSpecialRequest(reservationId) {
        const specialRequest = document.getElementById(`specialRequest-${reservationId}`);
        const tdSrP = document.getElementById(`td-sr-p-${reservationId}`);
        const chevronDown = document.getElementById(`chevron-down-${reservationId}`);
        const chevronUp = document.getElementById(`chevron-up-${reservationId}`);

        if (specialRequest.classList.contains('hidden')) {
            specialRequest.classList.remove('hidden');
            tdSrP.classList.remove('pb-4');
            chevronDown.classList.remove('hidden');
            chevronUp.classList.add('hidden');
        } else {
            specialRequest.classList.add('hidden');
            tdSrP.classList.add('pb-4');
            chevronDown.classList.add('hidden');
            chevronUp.classList.remove('hidden');
        }
    }
</script>