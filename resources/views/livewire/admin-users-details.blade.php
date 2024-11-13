<div class="w-1/2 m-auto mt-12">

    <div class="isolate -space-y-px rounded-md shadow-sm">
        <div class="relative rounded-md hover:bg-[#ffe094] transition rounded-b-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="name" class="block text-xs font-medium text-gray-900">Naam*</label>
            <input type="text" name="name" id="name" wire:model="name" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Jane Smith" value="{{$user->name}}">
            @error('name') <span class="error">Dit veld is verplicht</span> @enderror
        </div>

        <div class="relative hover:bg-[#ffe094] transition rounded-md rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">Email*</label>
            <input type="text" name="email" id="email" wire:model="email" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="{{$user->email}}">
            @error('email') <span class="error">Dit veld is verplicht</span> @enderror
        </div>
        <div class="relative rounded-md hover:bg-[#ffe094] transition rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">Nummer*</label>
            <input type="text" name="phone" id="phone" wire:model="phone" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="{{$user->phone}}">
            @error('phone') <span class="error">Dit veld is verplicht</span> @enderror
        </div>
        <div class="hidden relative rounded-md hover:bg-[#ffe094] transition rounded-t-none px-3 pb-1.5 pt-2.5 ring-1 ring-inset ring-gray-300 focus-within:z-10 focus-within:ring-2 focus-within:ring-indigo-600">
            <label for="job-title" class="block text-xs font-medium text-gray-900">ID</label>
            <input type="text" name="id" id="id" wire:model="id" class="block w-full border-0 p-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="{{$user->id}}" disabled>
        </div>

    </div>
    <div class="mt-12 w-full flex justify-evenly">
        <a href="https://activadis.ddev.site/admin/users/" >
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Terug
            </button>
        </a>
        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded" wire:click="update">
            Update
        </button>
        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 border border-red-700 rounded" wire:click="delete">
            Verwijder
        </button>
    </div>


    <!-- Success or error messages -->
    @if (session()->has('success'))
        <div class="bg-blue-100 mt-12 border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">Succes!</p>
            <p class="text-sm">Het updaten is gelukt</p>
        </div>
    @endif    @if (session()->has('successVerwijder'))
        <div class="bg-blue-100 mt-12 border-blue-500 text-blue-700 px-4 py-3" role="alert">
            <p class="font-bold">Succes!</p>
            <p class="text-sm">Het verwijderen is gelukt</p>
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
