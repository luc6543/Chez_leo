@php
    use Carbon\Carbon;
@endphp
<div class="px-4 sm:px-6 lg:px-8 mt-[6rem]">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold text-gray-900">Rekeningen</h1>
        </div>
    </div>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8">Gebruiker</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Datum</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Bedrag</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Betaald</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                                <span class="sr-only">Bekijken</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($bills as $bill)
                        <tr>
                            @if($bill->reservation->user)
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $bill->reservation->user->name }}</td>
                            @else
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8">{{ $bill->reservation->guest_name }}</td>
                            @endif
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ Carbon::parse($bill->reservation->start_time)->format('d-m-y H:i') }} <span class="font-bold text-black"> - </span> {{ Carbon::parse($bill->reservation->end_time)->format('d-m-y H:i') }} </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">€ {{ $bill->getSum() }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $bill->paid ? 'Ja' : 'Nee' }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8">
                                <a href="/bill/{{$bill->id}}" wire:navigate class="text-indigo-600 hover:text-indigo-900">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach

                    <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
