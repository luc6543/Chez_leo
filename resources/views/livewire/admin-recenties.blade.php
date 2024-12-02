<div class="mx-auto p-4 mt-24">
    <div wire:loading.flex class="bg-black/75 inset-0 fixed items-center justify-center transition-opacity duration-500
    ease-out
    delay-500 z-[99999]">
        <div class="border-4 border-yellow-500 border-t-transparent rounded-full w-12 h-12 animate-spin" role="status">
            <span class="sr-only">Laden...</span>
        </div>
    </div>
    <h1 class="text-2xl font-bold mb-4">Admin Reviews</h1>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @if($reviews->isEmpty())
            <p class="text-gray-700">No reviews found.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider flex flex-col items-start">
                            <span>Selecteer welke ai moet analyseren.</span>
                            <button
                                class="hover:text-gray-400 text-gray-700 transition border border-white hover:!border-gray-400 rounded-full px-2"
                                wire:click.prevent="toggleSelectAll">Selecteer alles</button>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recensie
                            tekst</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sterren
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gemaakt
                            op</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangepast
                            op</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <input type="checkbox" wire:model="selectedReviews" value="{{ $review->id }}" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->id }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div x-data="{ expanded: false }">
                                    <p x-show="!expanded">
                                        {{ Str::limit($review->review, 40) }}
                                        @if(strlen($review->review) > 40)
                                            <button class="text-blue-500 hover:underline ml-2" @click="expanded = true">Lees
                                                meer</button>
                                        @endif
                                    </p>
                                    <div x-show="expanded" x-cloak class="mt-2 p-2 rounded">
                                        <p class="whitespace-pre-wrap break-normal">{{$review->review}}</p>
                                        <button class="text-blue-500 hover:underline ml-2" @click="expanded = false">Lees
                                            minder</button>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->rating }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ date('d/m/Y H:i', strtotime($review->created_at)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ date('d/m/Y H:i', strtotime($review->updated_at)) }}</td>
                            <td id="approve-{{ $review->id }}"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $review->is_approved ? 'hidden' : '' }}">
                                <button wire:click="RecensieBevestiging({{ $review->id }})" class="hover:text-[#FEA116]">sta
                                    toe</button>
                            </td>
                            <td id="no_approve-{{ $review->id }}"
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $review->is_approved ? '' : 'hidden' }}">
                                <button wire:click="RecensieBevestiging({{ $review->id }})" class="hover:text-[#FEA116]">sta
                                    niet toe</button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">
                                <button onclick="this.disabled=true; setTimeout(() => { this.disabled=false; }, 1000);"
                                    wire:click="verwijderRecensie({{ $review->id }})"
                                    class="hover:text-red-600">verwijder</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <button type="submit" wire:click="getVerbeterPunten"
                    class="bg-sky-500 rounded shadow text-white p-2 px-4 mb-5">Laat AI de geselecteerde reviews
                    analyseren</button>
            </div>
        @endif
        <span wire:stream="AIGenerated">
            <ul class="list-disc">{!! $AIGenerated !!}</ul>
        </span>
    </div>
</div>