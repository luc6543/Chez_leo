<div class="bg-white">
    <div
        class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:grid lg:max-w-7xl lg:grid-cols-12 lg:gap-x-8 lg:px-8 lg:py-32">
        <!-- Linkerkolom: Overzicht -->
        <div class="lg:col-span-4">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Klanten recensies</h2>
            <div class="mt-3 flex items-center">
                <div>
                    <!-- Gemiddelde beoordeling -->
                    @php
                        $averageRating = $reviews->avg('rating');
                    @endphp
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}"
                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                    <p class="ml-2 text-sm text-gray-900">Gemiddelde van {{ $reviews->count() }} recensies</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Beoordelingsoverzicht</h3>
                <dl class="mt-2 space-y-4">
                    @foreach ($percentages as $stars => $percentage)
                        <div class="flex items-center text-sm">
                            <dt class="flex items-center">
                                <span class="text-gray-900">{{ $stars }} ster{{ $stars > 1 ? 'ren' : '' }}</span>
                            </dt>
                            <div class="ml-4 flex-1">
                                <div class="relative h-3 rounded-full bg-gray-200">
                                    <div 
                                        class="absolute inset-0 rounded-full bg-yellow-400" 
                                        style="width: {{ $percentage }}%;"></div>
                                </div>
                            </div>
                            <dd class="ml-3 text-sm text-gray-900">{{ $percentage }}%</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Deel jouw mening</h3>
                <p class="mt-1 text-sm text-gray-600">Was het allemaal goed bevallen? Laat het ons weten!</p>
                <a href="/recensies/toevoegen" wire:navigate
                    class="mt-6 inline-flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-50 sm:w-auto lg:w-full">Schrijf
                    een recensie</a>
            </div>
        </div>

        <!-- Rechterkolom: Recente Reviews -->
        <div class="mt-16 lg:col-span-7 lg:col-start-6 lg:mt-0">
            <h3 class="sr-only">Lijst van recensies</h3>
            <div class="flow-root">
                <div class="-my-12 divide-y divide-gray-200">
                    @foreach ($reviews as $review)
                        <div class="py-12">
                            <div class="flex items-center">
                                <img src="{{ $review->user->profile_photo_url ?? 'https://via.placeholder.com/256' }}"
                                    alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full">
                                <div class="ml-4">
                                    <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                    <div class="mt-1 flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $review->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-6 text-base text-gray-600 break-all">
                                <p>{{ $review->review }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
