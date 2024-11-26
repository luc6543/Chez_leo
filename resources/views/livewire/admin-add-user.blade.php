<div class="w-1/2 m-auto mt-12">

    <div class="isolate -space-y-px rounded-md shadow-sm">
        <div
            class="relative rounded-md rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="name" class="block text-xs font-medium text-gray-900">Naam*</label>
            <input type="text" name="name" id="name" wire:model="name"
                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                placeholder="Jane Smith">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div
            class="relative rounded-md rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">Email*</label>
            <input type="text" name="email" id="email" wire:model="email"
                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div
            class="relative rounded-md rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">Nummer*</label>
            <input type="text" name="phonenumber" id="phonenumber" wire:model="phone"
                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
            @error('phone') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div
            class="relative rounded-md rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">Wachtwoord*</label>
            <input type="text" name="password" id="password" wire:model="password"
                class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6">
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

    </div>
    <div class="mt-12 w-full flex justify-evenly">
        <a href="/admin/users/" wire:navigate>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Terug
            </button>
        </a>
        <button
            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded"
            wire:click="addUser">
            Toevoegen
        </button>
    </div>


    <!-- Success or error messages -->
    @if (session()->has('success'))
        <div class="bg-orange-100 mt-12 border-orange-500 text-orange-700 px-4 py-3" role="alert">
            <p class="font-bold">Succes!</p>
            <p class="text-sm">Het toevoegen is gelukt</p>
        </div>
    @endif

    @if (session()->has('error'))
        <div role="alert">
            <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                Error
            </div>
            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>