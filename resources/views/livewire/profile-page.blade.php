@php
    use Carbon\Carbon;
@endphp
<div class="my-28" x-data="{modalOpened : false}" @close-modal=" modalOpened = false " @open-modal="modalOpened = true">
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
    @if (session()->has('message'))
        <div class="fixed z-50 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
            <div class="alert alert-success p-4 mt-10">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <div class="{{$reservations->isEmpty() ? 'lg:w-3/4' : 'lg:w-[99%]' }} mt-2 w-full flex flex-col lg:flex-row bg-white rounded shadow gap-2 items-center">
        <div class="gap-5 p-4 flex flex-wrap justify-around items-center w-full">
            <span
                class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-500">
                <span class="font-medium leading-none text-white">
                    {{ Auth::user()->getInitials() }}
                </span>
            </span>
            <div class="flex flex-col gap-5" x-data="{passReset : false}" @password-changed="passReset=false">
                <span>{{ Auth::user()->name }}</span>
                <span class="text-gray-500">{{ Auth::user()->email }}</span>
                {{-- <button @click="passReset = !passReset">Wachtwoord veranderen</button> --}}
                {{--<button class="bg-sky-500 p-2 rounded shadow text-white">Info bewerken</button>--}}
                {{-- <div x-show="passReset" x-collapse style="display:none;">
                    <form class="flex flex-col gap-2" wire:submit="passReset">
                        <input wire:model="newPass" type='password' placeholder="nieuw wachtwoord">
                        @error('newPass')
                            <span>{{ $message }}</span>
                        @enderror
                        <input wire:model="newPassConfirm" type='password' placeholder="nieuw wachtwoord herhalen">
                        @error('newPass')
                            <span>{{ $message }}</span>
                        @enderror
                        <button class="p-2 px-4 rounded shadow bg-white text-black" type="submit">Wachtwoord aanpassen</button>
                    </form>
                </div> --}}
            </div>
        </div>
        <div class="w-full mt-8">
            <div class="flow-root">
                <div class="block md:hidden">
                    <!-- Mobile Version -->
                    @foreach(Auth::user()->reservations as $reservation)
                    <div class="border border-gray-300 rounded-lg mb-4 p-4 mx-4">
                        <div class="flex justify-between text-sm font-medium">
                            <span class="font-extrabold">Reserverings nummer:</span>
                            <span class="font-light">{{ $reservation->id }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-extrabold">Tafel nummer:</span>
                            <span class="font-light">{{ $reservation->table->table_number }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-extrabold">Datum:</span>
                            <span class="font-light">{{ date('d/m/Y H:i', strtotime($reservation->start_time)) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-extrabold">Rekening:</span>
                            <span class="font-light">€ {{ $reservation->bill->getSum() }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-extrabold">Voldaan:</span>
                            <span class="font-light">{{ $reservation->bill->paid ? 'Ja' : 'Nee' }}</span>
                        </div>
                        <div class="flex justify-center">
                                <a href="/bill/{{ $reservation->bill->id }}" class="border rounded-md px-14 py-2 bg-[#FEA116] text-white hover:bg-[#fea116a5]">
                                    <div class="">Bekijken</div>
                                </a>
                        </div>
                        @if(Carbon::parse($reservation->start_time)->gt(Carbon::now()->addHours(24)))
                            <div class="flex justify-center">
                                <button class="border rounded-md px-12 py-2 bg-[#FEA116] text-white hover:bg-[#fea116a5]" >aanpassen</button>
                            </div>
                            <div class="flex justify-center">
                                <button class="border rounded-md px-[3.2rem] py-2 bg-red-500 text-white hover:bg-red-400">annuleren</button>
                            </div>
                        @endif
                    </div>
                    @endforeach
                    <div class="px-4 py-3">
                        <small class="text-xs">*Reserveringen kunnen niet meer worden aangepast binnen 24 uur van de reservering</small>
                    </div>
                </div>
                <div class="hidden md:block">
                    <!-- Desktop Version -->
                    @if ($reservations->isEmpty())
                        <div class="flex justify-center items-center">
                            <span class="text-xl text-gray-500">Geen reserveringen gevonden</span>
                        </div>
                    @else
                    <div class="px-4 py-3">
                        <small class="text-xs">*Reserveringen kunnen niet meer worden aangepast binnen 24 uur van de reservering</small>
                    </div>
                        <div class="overflow-hidden md:px-8">
                            <table class="w-full divide-y divide-gray-300 text-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-0">Reserverings nummer</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Tafel nummer</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Datum</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Rekening</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Voldaan</th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900"></th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900"></th>
                                        <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach(Auth::user()->reservations as $reservation)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $reservation->id }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $reservation->table->table_number }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ date('d/m/Y H:i', strtotime($reservation->start_time)) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">€ {{ $reservation->bill->getSum() }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $reservation->bill->paid ? 'Ja' : 'Nee' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <a href="/bill/{{ $reservation->bill->id }}" class="hover:underline">Bekijken</a>
                                        </td>
                                        @if(Carbon::parse($reservation->start_time)->gt(Carbon::now()->addHours(24)))
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <a class="hover:underline cursor-pointer" wire:click="edit({{ $reservation->id }})">Aanpassen</a>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 ">
                                                <a class="hover:underline cursor-pointer text-red-500 hover:text-red-400" wire:click="annuleerReservering({{ $reservation->id }})">Annuleren</a>
                                            </td>
                                        @else
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="text-gray-500 cursor-not-allowed">Aanpassen</span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="text-gray-500 cursor-not-allowed">annuleren</span>
                                            </td>
                                        @endif
                                        
                                        {{-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 "><button class="border rounded-md px-5 py-2 bg-red-500 text-white hover:bg-red-400">Annuleren</button></td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
                    </div>
                    <div class="mb-4">
                        <x-flatpickr id="flatPickr" value="{{$start_time}}" max-time="20:30" onChange="handleChange"
                            :disable="['monday', 'tuesday']" class="mt-1 h-full block resize-none bg-white w-full !rounded-md !border-gray-300" date-format="d-m-Y" placeholder="Datum & Tijd"
                            :min-date="today()" wire:model="start_time" show-time />
                        @error('start_time')
                            <div class="alert alert-danger text-red-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Speciaal verzoek</label>
                        <textarea maxlength="255"  wire:model.defer="special_request"
                            class="mt-1 block resize-none w-full rounded-md border-gray-300"></textarea>
                        @error('special_request')
                        <div class="alert alert-danger text-red-500">
                            {{ $message }}
                        </div>
                        @enderror
                        <small class="text-xs">*Als je met met meer personen wilt komen neem dan contact met ons op</small>
                    </div>
                    
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Verander</button>
                    <button type="button" @click="modalOpened = false" wire:click="resetInputFields"
                        class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Annuleer</button>
                </form>
            </div>
        </div>
    </div>
</div>

