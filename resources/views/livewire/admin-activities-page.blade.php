<div class="flex flex-col gap-5 w-full p-4" x-data="{ newActivityModalOpened : false }" x-on:activity-created.window="newActivityModalOpened = false">

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Activiteiten</h1>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <a href="/admin/activity/new" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Nieuwe activiteit</a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Titel</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Locatie</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start tijd</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Eind tijd</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Eigen kosten</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Aantal deelnemers</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-100 bg-white z-2">
                            @foreach($activities as $activity)
                                <tr x-data="{ confirmationModalOpened: false }" x-on:activity-deleted.window="confirmationModalOpened = false" class="hover:bg-[#ffe094] transition">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><a href="/activity/{{$activity->id}}" wire:navigate>{{$activity->title}}</a></td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->location }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@formatDate($activity->startTime)</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@formatDate($activity->endTime)</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->cost }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->participants->count() }} / {{ $activity->maxParticipants ?? "-" }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 flex gap-5 justify-end items-center">
                                        <a wire:navigate href="/admin/activity/{{$activity->id}}/edit/" class="text-indigo-600 hover:text-indigo-900">Aanpassen</a>
                                        <button class="bg-red-500 p-2 px-4 shadow text-white rounded" @click="confirmationModalOpened = true">Verwijderen</button>
                                    </td>
                                    <td colspan="6" class="z-100">
                                        <div x-show="confirmationModalOpened" class="fixed flex justify-center items-center w-screen h-screen left-0 top-0 z-5 bg-black/75">
                                            <div class="bg-white p-10 rounded flex flex-col gap-5" @click.away="confirmationModalOpened = false">
                                                <h1>Weet je het zeker???</h1>
                                                <button @click="confirmationModalOpened = false" class="bg-gray-500 p-2 text-white rounded">Nee</button>
                                                <button wire:click="deleteActivity({{$activity->id}})" class="bg-red-500 p-2 text-white rounded">Ja</button>
                                            </div>
                                        </div>
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
