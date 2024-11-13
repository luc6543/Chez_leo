<div class="min-h-full">
    <div class="p-32" style=""></div>

    <main class="-mt-32 z-1">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white px-5 py-6 shadow sm:px-6">
                <main class="container mx-auto px-10 py-5 flex flex-col gap-3">
                    <form wire:submit.prevent="addActivity">
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base font-semibold leading-7 text-gray-900">Activiteit Aanmaken</h2>

                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-4">
                                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Titel
                                            <sup class="text-red-500">*</sup></label>
                                        <div class="mt-2">
                                            <div
                                                class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                <input type="text" name="title" id="title"
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
                                                   wire:model="newActivity.startTime"
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
                                                   wire:model="newActivity.endTime"
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
                                                      required></textarea>
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
                                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                    <label for="file-upload"
                                                           class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                        @if(isset($newActivity->img))
                                                            <span>Afbeelding geupload</span>
                                                        @else
                                                            <span>Afbeelding uploaden</span>
                                                        @endif
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

                </main>

            </div>
        </div>
    </main>
</div>
