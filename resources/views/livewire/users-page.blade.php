<div class="mt-[190px]" x-data="{newUserModal : false , modifyUserModal : false}" @user-created.window="newUserModal = false" @user-modified.window="modifyUserModal = false">
    @if (session()->has('userMessage'))
        <div class="fixed z-50 top-0 left-0 w-screen p-4 mt-10 flex justify-center">
            <div class="alert alert-success p-4 mt-10">
                {{ session('userMessage') }}
            </div>
        </div>
    @endif
    <div class="fixed bg-black/75 top-0 left-0 z-50 w-screen h-screen flex justify-center items-center" x-show="newUserModal" style="display:none;">
        <div class="p-6 shadow bg-white flex flex-col gap-5 rounded" @click.away="newUserModal = false">
            <form wire:submit.prevent="createUser" class="flex flex-col gap-2">
                <div>
                    <input wire:model="newUser.name" placeholder="naam" class="@error('newUser.name') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('newUser.name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="newUser.email" placeholder="email" class="@error('newUser.email') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('newUser.email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="newUser.password" placeholder="Wachtwoord" type="password" class="@error('newUser.password') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('newUser.password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="newUser.passwordRepeat" placeholder="Wachtwoord herhalen" type="password" class="@error('newUser.passwordRepeat') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('newUser.passwordRepeat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-sky-500 p-2 px-4 rounded shadow text-white">Toevoegen</button>
            </form>

        </div>
    </div>
    <div class="fixed bg-black/75 top-0 left-0 z-50 w-screen h-screen flex justify-center items-center" x-show="modifyUserModal" style="display:none;">
        <div class="p-6 shadow bg-white flex flex-col gap-5 rounded" @click.away="modifyUserModal = false">
            <form wire:submit.prevent="modifyUser" class="flex flex-col gap-2">
                <div>
                    <input wire:model="modifyingUser.name" placeholder="naam" class="@error('modifyingUser.name') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('modifyingUser.name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="modifyingUser.email" placeholder="email" class="@error('modifyingUser.email') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('modifyingUser.email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="modifyingUser.password" placeholder="Wachtwoord" type="password" class="@error('modifyingUser.password') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('modifyingUser.password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <input wire:model="modifyingUser.passwordRepeat" placeholder="Wachtwoord herhalen" type="password" class="@error('modifyingUser.passwordRepeat') border-red-500 @enderror p-2 px-4 rounded shadow">
                    @error('modifyingUser.passwordRepeat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-sky-500 p-2 px-4 rounded shadow text-white">Aanpassen</button>
            </form>

        </div>
    </div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto ml-[2rem]">
                <h1 class="text-base font-semibold text-gray-900">Gebruikers</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button" @click="newUserModal = true" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Gebruiker toevoegen</button>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-my-2 overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <input class="border-none bg-white p-2 px-4 rounded shadow" wire:model.live="searchTerm" placeholder="Zoeken..">
                    <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg mt-2">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Naam</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rollen</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">Acties
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y w-full divide-gray-200 bg-white">
                            @foreach($users as $user)
                                <tr class="w-full">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{$user->name}}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$user->email}}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @foreach($roles as $role)
                                            @if($role->name != 'klant')
                                                @if($user->hasRole($role))
                                                    <span wire:click.prevent="toggleRole({{$role}},{{$user}})" class="p-2 bg-green-500 text-white cursor-pointer rounded-full">{{ $role->name }}</span>
                                                @else
                                                    <span wire:click.prevent="toggleRole({{$role}},{{$user}})" class="p-2 cursor-pointer bg-red-500 text-white rounded-full">{{ $role->name }}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex gap-5" x-data="{confirmationModal : false }">
                                        <button @click="modifyUserModal = true" wire:click="loadUser({{$user->id}})" class="text-indigo-600 hover:text-indigo-900">Aanpassen</button>
                                        <button @click="confirmationModal = true" class="text-white font-bold bg-red-500 p-2 px-4 rounded shadow">Verwijderen</button>

                                        {{--Confirmation modal--}}
                                        <div class="fixed bg-black/75 top-0 left-0 z-50 w-screen h-screen flex justify-center items-center" style="display:none;" x-show="confirmationModal">
                                            <div class="p-6 shadow bg-white flex flex-col gap-5" @click.away="confirmationModal = false">
                                                <h1>Weet je het zeker?</h1>
                                                <div class="w-full flex justify-around items-center">
                                                    <button wire:click="delete({{$user}})" class="p-2 px-4 rounded shadow bg-red-500 text-white">Verwijderen</button>
                                                    <button @click="confirmationModal = false" class="p-2 px-4 rounded shadow bg-indigo-500 text-white">Annuleren</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{----}}
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

</div>
