@php
    use Carbon\Carbon;
@endphp

<div x-data="{modalOpened : false}" @close-modal=" modalOpened = false " @open-modal="modalOpened = true">
    @push('styles')
        @include('flatpickr::components.style')
    @endpush
    @push('scripts')
        @include('flatpickr::components.script')
        <script wire:ignore>
            function onClose() {
                @this.updateTableList();
            }

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


            const selected = document.querySelector(".selected");
            const optionsContainer = document.querySelector(".options-container");
            const searchBox = document.querySelector(".search-box input");
            const optionsList = document.querySelectorAll(".option");

            selected.addEventListener("click", () => {
                optionsContainer.classList.toggle("max-h-60");
                optionsContainer.classList.toggle("opacity-100");
                optionsContainer.classList.toggle("overflow-y-auto");
                optionsContainer.classList.toggle("hidden");

                searchBox.value = "";
                filterList("");

                if (optionsContainer.classList.contains("max-h-60")) {
                    searchBox.classList.remove("hidden");
                    searchBox.focus();
                } else {
                    searchBox.classList.add("hidden");
                }
            });

            optionsList.forEach(o => {
                o.addEventListener("click", () => {
                    selected.innerHTML = o.querySelector("label").innerHTML;
                    optionsContainer.classList.remove("max-h-60", "opacity-100", "overflow-y-auto");
                    searchBox.classList.add("hidden");
                });
            });

            searchBox.addEventListener("keyup", function (e) {
                filterList(e.target.value);
            });

            const filterList = searchTerm => {
                searchTerm = searchTerm.toLowerCase();
                optionsList.forEach(option => {
                    let label = option.querySelector("label").innerText.toLowerCase();
                    option.style.display = label.includes(searchTerm) ? "block" : "none";
                });
            };
        </script>
        <script src="/js/flatpickr.js"></script>
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
                                                Tafelnummers</th>
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
                                                    {{ ($reservation->user->name ?? $reservation->guest_name) ?? 'Geen klant' }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $reservation->people }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap pt-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    @foreach ($reservation->tables as $table)
                                                        {{ $table->table_number }}{{ $loop->last ? '' : ', ' }}
                                                    @endforeach
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
                                                    <button
                                                        onclick="this.disabled=true; setTimeout(() => { this.disabled=false; }, 1000);"
                                                        wire:click="delete({{ $reservation->id }})"
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
        class="fixed inset-0 z-[51] flex items-center justify-center bg-black bg-opacity-50 overflow-y-scroll">
        <div x-transition class="bg-white rounded-lg px-6 pt-3 w-1/3">
            <h2 class="text-lg font-semibold mb-4">
                {{ $reservationId ? 'Verander de reservering' : 'Maak een reservering' }}
            </h2>

            <form wire:submit.prevent="store">
                <div class="mb-4 mt-2">
                    <div class="flex items-center  justify-between">
                        <input wire:model.defer="guest_name" id="guest-name"
                        class="{{ $showGuestNameInput ? 'block' : 'hidden'}} w-full rounded-md border-gray-300 @error('guest_name') border-red-500 @enderror"
                        placeholder="Type de naam van de klant">                        
                        <div class="{{ !$showGuestNameInput ? 'block' : 'hidden'}} select-box relative flex flex-col w-full">
                            <div class="options-container absolute top-full left-0 w-full bg-white max-h-0 opacity-0 overflow-y transition-all duration-300 border rounded-md z-10 hidden">
                                @foreach($users as $user)
                                    <div class="option cursor-pointer p-2 hover:bg-gray-100">
                                        <input type="radio" class="radio hidden " id="{{ $user->id }}" name="user_id"
                                            wire:model.live="user_id" value="{{ $user->id }}" />
                                        <label for="{{ $user->id }}" class="block">{{ $user->id }}: {{ $user->name }}</label>
                                    </div>
                                @endforeach
                            </div>
            
                            <div class="selected bg-white p-2 border rounded-md cursor-pointer flex items-center justify-between">
                                @if ($user_id)
                                    {{ $user_id }}: {{ $users->where('id', $user_id)->first()->name }}
                                @else
                                    Selecteer een klant
                                @endif
                                <span class="arrow transform transition-transform duration-300">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </div>
            
                            <div class="search-box relative">
                                <input type="text" placeholder="Zoek een klant"
                                    class="w-full p-2 border rounded-md focus:outline-none hidden" />
                            </div>
                        </div>
            
                        <button type="button" wire:click="toggleGuestInput" class="ml-4 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </button>
                    </div>
                    @error('guest_name')
                    <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                @enderror
                </div>
                <div class="mb-4">
                    <div class="" id="date3" data-target-input="nearest">
                        <input type="text" id="flatPickr" class="bg-white !rounded-md block w-full border-gray-300"
                            placeholder="Datum & Tijd" wire:model.defer="start_time">
                    </div>
                    @error('start_time')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <input wire:model.live.debounce.20ms="people" type="number" min="1" max="{{ $maxChairs }}"
                        class="block w-full rounded-md border-gray-300" placeholder="Personen ({{ $maxChairs }} max)">
                    @error('people')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    @if($table_ids)
                        <div class="flex overflow-x-auto w-full h-min border rounded-md items-center">
                            @foreach ($table_ids as $table_id)
                                <div class="bg-gray-100 border rounded-md h-8 m-1 p-1 flex items-center">
                                    <label class="w-max text-sm font-medium">Tafel {{ $table_id }}</label>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-5 ml-1 hover:text-red-500"
                                        wire:click="toggleTable({{ $table_id }})">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                    
                    <div x-data="{ open: false }" class="relative w-full">
                            <!-- Button to Toggle Dropdown -->
                            <button @click="open = !open" type="button"
                                class="block w-full border rounded-md bg-white p-2 text-left">
                                Selecteer één of meerdere tafels
                            </button>
                
                            <!-- Dropdown Menu -->
                            <div x-show="open" @click.outside="open = false"
                                class="absolute mt-1 w-full rounded-md bg-white border border-gray-300 shadow-lg max-h-60 overflow-auto z-10">
                                @foreach($tables as $table)
                                    @if(empty($table_ids) || !in_array($table->id, (array) $table_ids))
                                        <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                            wire:click="toggleTable({{ $table->id }})">
                                            Tafel {{ $table->table_number }}: {{ $table->chairs }}
                                            {{ $table->chairs == 1 ? 'stoel' : 'stoelen' }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <button type="button"
                            onclick="this.disabled=true; setTimeout(() => { this.disabled=false; }, 1000);"
                            wire:click="autoSelectTables"
                            class="ml-4 mr-3 {{ $people && $start_time ? 'block' : 'hidden'}}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24"
                                height="24" stroke-width="2">
                                <path d="M3 6h18"></path>
                                <path d="M4 6v13"></path>
                                <path d="M20 19v-13"></path>
                                <path d="M4 10h16"></path>
                                <path d="M15 6v8a2 2 0 0 0 2 2h3"></path>
                            </svg>
                        </button>
                    </div>
                
                    <!-- Error Message for table_ids -->
                    @error('table_ids')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <textarea maxlength="255" wire:model.defer="special_request"
                        class="block w-full resize-none rounded-md border-gray-300"
                        placeholder="Speciaal verzoek"></textarea>
                    @error('special_request')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4 flex items-center gap-4">
                    <label class="block text-sm font-medium">Actief</label>
                    <input type="checkbox" wire:model.defer="active" class="block rounded-md border-gray-300">
                </div>
            
                @if (session()->has('error'))
                    <div class="alert alert-danger text-red-500">
                        {!! session('error') !!}
                    </div>
                @endif
            
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">
                    {{ $reservationId ? 'Verander' : 'Reserveer' }}
                </button>
                <button type="button" @click="modalOpened = false" wire:click="resetInputFields"
                    class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Annuleer</button>
            </form>
        </div>
    </div>
</div>