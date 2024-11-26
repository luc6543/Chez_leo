<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg">
        <!-- Controleer of de gebruiker ingelogd is -->
        @auth
            <!-- Succesbericht -->
            @if (session()->has('message'))
                <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Formulier voor ingelogde gebruikers -->
            <form wire:submit.prevent="saveReview" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <div class="mb-4">
                    <label for="review" class="block text-gray-700 text-sm font-bold mb-2">Review:</label>
                    <textarea 
                        id="review" 
                        wire:model.debounce.300ms="review" 
                        maxlength="255" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"
                        rows="4"
                    ></textarea>
                    @error('review') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                    <div class="flex items-center space-x-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg 
                            wire:click="setRating({{ $i }})" 
                            data-rating="{{ $i }}" 
                            class="star w-8 h-8 cursor-pointer {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                            viewBox="0 0 20 20" 
                            fill="currentColor" 
                            aria-hidden="true">
                            <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c-.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
                            </svg>
                        @endfor
                    </div>
                    @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Dynamische knoptekst -->
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    {{ $reviewId ? 'Update Review' : 'Plaats Review' }}
                </button>
            </form>
        <!-- @else
             Bericht voor uitgelogde gebruikers
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Log in om een review te plaatsen</h2>
                <p class="text-gray-600">
                    Je moet ingelogd zijn om een review te kunnen schrijven. 
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Log in</a> 
                    of 
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-semibold">registreer</a> 
                    om een account aan te maken.
                </p>
            </div> -->
        @endauth
    </div>
</div>
