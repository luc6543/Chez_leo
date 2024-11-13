<div class="min-h-full" x-data="{ ShowMailModal : false }">
    <div class="p-32" style="background: url('{{$activity->img}}')"></div>
    <div x-show="ShowMailModal" class="fixed top-0 left-0 flex bg-black/75 z-10 flex flex-col w-screen h-screen justify-center items-center" x-data="{ showParticipantsSelect : false}">

        <div class="flex flex-col gap-5 w-1/2 bg-white rounded py-6 p-4 py-6" @click.away="ShowMailModal = false">
            <input wire:model="title" placeholder="titel">
            <input wire:model="subject" placeholder="onderwerp">
            <textarea wire:model="content" placeholder="content"></textarea>
            <button class="bg-gray-400 text-white flex justify-between rounded shadow w-full p-2" @click="showParticipantsSelect = !showParticipantsSelect">Deelnemers selecteren <svg x-show="!showParticipantsSelect" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg> <svg x-show="showParticipantsSelect" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg></button>
            <div x-show="showParticipantsSelect" x-collapse>
                <ul>
                    <li wire:click="toggleAll" class="bg-gray-100 rounded p-2 text-center cursor-pointer" wire:click>Toggle all</li>
                @foreach($activity->participants as $participant)
                    <li class="flex justify-between gap-x-6 py-2">
                            <div class="flex min-w-0 gap-x-4">
                                <span
                                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500"><span
                                        class="font-medium leading-none text-white">{{ $participant->getInitials() }}</span></span>
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{$participant->name}}</p>
                                </div>
                            </div>
                        <input type="checkbox" wire:model="users.{{ base64_encode($participant->email) }}" id="">
                    </li>
                @endforeach
                </ul>
            </div>
            <button wire:click="sendMail" class="bg-emerald-800 p-2 px-4 text-white hover:bg-emerald-500 transition shadow">Test</button>
        </div>

    </div>

    <main class="-mt-32 z-1">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                <main class="container mx-auto px-10 py-5 flex flex-col gap-3">
                    <form wire:submit.prevent="editActivity">
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Activiteit Bewerken</h2>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Titel
                                            <sup class="text-red-500">*</sup></label>
                                        <div class="mt-2">
                                            <div
                                                class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="title" id="title" value="{{$activity->title}}"
                                                       wire:model="newActivity.title"
                                                       class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                                                       required>
                                                @error('newActivity.title')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="minParticipants"
                                               class="block text-sm font-medium leading-6 text-gray-900">Prijs</label>
                                        <div class="mt-2">
                                            <input type="number" name="cost" id="cost" min="0"
                                                   value="{{$activity->cost}}"
                                                   wire:model="newActivity.cost"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('newActivity.cost')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="maxParticipants"
                                               class="block text-sm font-medium leading-6 text-gray-900">Locatie</label>
                                        <div class="mt-2">
                                            <input type="text" name="location" id="location"
                                                   value="{{$activity->location}}"
                                                   wire:model="newActivity.location"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('newActivity.location')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="sm:col-span-3">
                                        <label for="starttime"
                                               class="block text-sm font-medium leading-6 text-gray-900">Van <sup
                                                class="text-red-500">*</sup></label>
                                        <div class="mt-2">
                                            <input type="datetime-local" name="starttime" id="starttime"
                                                   value="{{$activity->startTime}}" wire:model="newActivity.startTime"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                   required>
                                            @error('newActivity.startTime')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="endtime"
                                               class="block text-sm font-medium leading-6 text-gray-900">Tot <sup
                                                class="text-red-500">*</sup></label>
                                        <div class="mt-2">
                                            <input type="datetime-local" name="endtime" id="endtime"
                                                   value="{{$activity->endTime}}" wire:model="newActivity.endTime"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                   required>
                                            @error('newActivity.endTime')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="minParticipants"
                                               class="block text-sm font-medium leading-6 text-gray-900">Minimaal aantal
                                            deelnemers</label>
                                        <div class="mt-2">
                                            <input type="number" name="minParticipants" id="minParticipants" min="0"
                                                   value="{{$activity->minParticipants}}"
                                                   wire:model="newActivity.minParticipants"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('newActivity.minParticipants')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="maxParticipants"
                                               class="block text-sm font-medium leading-6 text-gray-900">Maximaal aantal
                                            deelnemers</label>
                                        <div class="mt-2">
                                            <input type="number" name="maxParticipants" id="maxParticipants" min="0"
                                                   value="{{$activity->maxParticipants}}"
                                                   wire:model="newActivity.maxParticipants"
                                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('newActivity.maxParticipants')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="description"
                                               class="block text-sm font-medium leading-6 text-gray-900">Beschrijving
                                            <sup class="text-red-500">*</sup></label>
                                        <div class="mt-2">
                                            <textarea id="description" name="description" rows="3"
                                                      wire:model="newActivity.description"
                                                      class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                      required>{{$activity->description}}</textarea>
                                            @error('newActivity.description')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-span-full">
                                        <label for="cover-photo"
                                               class="block text-sm font-medium leading-6 text-gray-900">Afbeelding<sup
                                                class="text-red-500">*</sup></label>
                                        <div
                                            class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                            <div class="text-center">
                                                @if($newActivity["img"] === $activity->img)
                                                    <img class="max-w-xs max-h-xs" src="{{Vite::Asset('storage/app/'.$newActivity["img"])}}" alt="">
                                                @else
                                                    Nieuwe afbeelding geupload
                                                @endif

                                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                    <label for="file-upload"
                                                           class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                        <span>Nieuwe afbeelding</span>
                                                        <input id="file-upload" name="file-upload" type="file"
                                                               class="sr-only" wire:model="newActivity.img">
                                                    </label>
                                                    @error('newActivity.img')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="/admin/activities" class="text-sm font-semibold leading-6 text-gray-900">Annuleren
                            </a>
                            <button type="submit"
                                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Opslaan
                            </button>
                        </div>
                    </form>
                    <button class="bg-emerald-800 text-white text-bold rounded p-2 px-4" @click="ShowMailModal = true">deelnemers mailen</button>

                </main>

            </div>
        </div>
    </main>
</div>
