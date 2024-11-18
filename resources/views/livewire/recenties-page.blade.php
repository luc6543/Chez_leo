<div class="container mx-auto p-6">
    <!-- Form om een nieuwe review te maken -->
    <div class="mb-6">
        
            <form wire:submit.prevent="addReview" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                <div class="mb-4">
                    <label for="review" class="block text-gray-700 text-sm font-bold mb-2">Review:</label>
                    <textarea id="review" wire:model="review" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    @error('review') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                    <select id="rating" wire:model="rating" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Selecteer een rating</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Plaats Review
                </button>
            </form>
        
            <p class="text-red-500">Je moet <a href="{{ route('login') }}" class="text-blue-500">inloggen</a> om een review te plaatsen.</p>
        
    </div>

    <!-- Overzicht van alle reviews -->
    <div>
        <h2 class="text-xl font-bold mb-4">Alle Reviews:</h2>
        
            <div class="bg-gray-100 shadow rounded p-4 mb-4">
                <p class="font-bold">Gebruikersnaam</p>
                <p class="text-sm text-gray-600">Gemaakt op</p>
                <p class="my-2">Review tekst</p>
                <p class="text-yellow-500">Rating: rating van de 5</p>
            </div>
        
    </div>
</div>
