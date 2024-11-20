<div class="flex flex-col mt-[200px] gap-5 justify-center items-center mb-5">
    @if (session()->has('message'))
        <div class="fixed z-50 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
            <div class="alert alert-success p-4 mt-10">
                {{ session('message') }}
            </div>
        </div>
    @endif
    <div class="lg:w-3/4 w-full flex flex-col lg:flex-row bg-white rounded shadow gap-2 items-center">
        <div class="gap-5 p-4 flex justify-around items-center w-fit gap-5">
            <span
                class="inline-flex h-20 w-20  items-center justify-center rounded-full bg-gray-500">
                <span class="font-medium leading-none text-white">{{ Auth::user()->getInitials() }}</span>
            </span>
            <div class="flex flex-col gap-2" @password-changed="showPassReset = false" x-data="{showPassReset : false}">
                <span>{{ Auth::user()->name }}</span>
                <span class="text-gray-500">{{ Auth::user()->email }}</span>
               {{-- <button class="bg-sky-500 p-2 rounded shadow text-white">Info bewerken</button> --}}
                <button @click="showPassReset = !showPassReset">Wachtwoord aanpassen</button>
                <form wire:submit="passReset" x-show="showPassReset" x-cloak x-transition>
                    <input wire:model="newPass" placeholder="nieuw wachtwoord">
                    @error('newPass') <span class="error">{{ $message }}</span> @enderror
                    <input wire:model="newPassConfirm" placeholder="nieuw wachtwoord herhalen">
                    @error('newPassConfirm') <span class="error">{{ $message }}</span> @enderror
                    <button type="submit">Wachtwoord veranderen</button>
                </form>

            </div>
    </div>
        <div class="w-full">
            <div class="mt-8 flow-root">
                <div class="overflow-x-auto">
                    <div class="min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="w-full divide-y divide-gray-300 text-xs">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Reserverings nummer</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tafel nummer</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Datum</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rekening</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Voldaan</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach(Auth::user()->reservations as $reservation)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ $reservation->id }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $reservation->table->table_number }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ date('d/m/Y H:i',strtotime($reservation->start_time)) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">€ {{ $reservation->bill->getSum() }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $reservation->bill->paid ? 'Ja' : 'Nee' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><a href="/bill/{{$reservation->bill->id}}">Bekijken</a></td>
                            </tr>
                            @endforeach

                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
