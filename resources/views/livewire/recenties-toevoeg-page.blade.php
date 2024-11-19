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
            <form wire:submit.prevent="addReview" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
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
                    <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                    <select 
                        id="rating" 
                        wire:model="rating" 
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option value="">Selecteer een rating</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                    Plaats Review
                </button>
            </form>
        @else
            <!-- Bericht voor uitgelogde gebruikers -->
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Log in om een review te plaatsen</h2>
                <p class="text-gray-600">
                    Je moet ingelogd zijn om een review te kunnen schrijven. 
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-700 font-semibold">Log in</a> 
                    of 
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-700 font-semibold">registreer</a> 
                    om een account aan te maken.
                </p>
            </div>
        @endauth
    </div>
</div>
