<div class="flex flex-col mt-24 lg:mt-44 gap-5 justify-center items-center mb-5">
    @if (session()->has('message'))
        <div class="fixed z-50 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
            <div class="alert alert-success p-4 mt-10">
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- User Profile Section -->
    <div class="lg:w-3/4 w-full flex flex-col lg:flex-row bg-white rounded shadow gap-2 items-center">
        <div class="gap-5 p-4 flex flex-wrap justify-around items-center w-full">
            <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-500">
                <span class="font-medium leading-none text-white">
                    {{ Auth::user()->getInitials() }}
                </span>
            </span>
            <div class="flex flex-col gap-5" x-data="{ passReset : false }" @password-changed="passReset=false">
                <span>{{ Auth::user()->name }}</span>
                <span class="text-gray-500">{{ Auth::user()->email }}</span>
            </div>
        </div>
    </div>

    <!-- Recensies Section -->
    <div class="w-full mt-8">
        <h2 class="text-xl font-bold mb-4">Mijn Recensies</h2>
        
        <!-- Check if the user has reviews -->
        @if ($reviews->isEmpty())
            <p class="text-gray-500">Je hebt nog geen recensies geplaatst.</p>
        @else
            @foreach ($reviews as $review)
                <div class="border border-gray-300 rounded-lg mb-4 p-4">
                    <h3 class="text-lg font-semibold">{{ $review->title }}</h3>
                    <p class="text-gray-700">{{ $review->review }}</p>
                    <div class="flex gap-4 mt-3">
                        <!-- Bewerken button -->
                        <a href="{{ route('recenties.bijwerken', $review->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Bewerken
                        </a>

                        <!-- Verwijderen button -->
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                wire:click="deleteReview({{ $review->id }})">
                            Verwijderen
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Reserveringen Section -->
    <div class="w-full mt-8">
        <div class="flow-root">
            <!-- Mobile Version -->
            <div class="block md:hidden">
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
                                Bekijken
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Desktop Version -->
            <div class="hidden md:block">
                <div class="overflow-hidden md:px-5">
                    <table class="w-full divide-y divide-gray-300 text-sm">
                        <thead>
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-0">Reserverings nummer</th>
                                <th class="px-3 py-3.5 text-left font-semibold text-gray-900">Tafel nummer</th>
                                <th class="px-3 py-3.5 text-left font-semibold text-gray-900">Datum</th>
                                <th class="px-3 py-3.5 text-left font-semibold text-gray-900">Rekening</th>
                                <th class="px-3 py-3.5 text-left font-semibold text-gray-900">Voldaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach(Auth::user()->reservations as $reservation)
                                <tr>
                                    <td class="py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-0">{{ $reservation->id }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500">{{ $reservation->table->table_number }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500">{{ date('d/m/Y H:i', strtotime($reservation->start_time)) }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500">€ {{ $reservation->bill->getSum() }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500">{{ $reservation->bill->paid ? 'Ja' : 'Nee' }}</td>
                                    <td class="px-3 py-4 text-sm text-gray-500">
                                        <a href="/bill/{{ $reservation->bill->id }}" class="hover:underline">Bekijken</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
