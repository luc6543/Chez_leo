
<div class="w-[100%] mb-4 flex flex-col items-center" x-data="{open: false}">
    <div>
    <span class="inline-flex m-4 ml-[-50px] w-[150px] h-[150px] absolute items-center justify-center rounded-full bg-gray-500"><span class="font-medium text-[30px] leading-none text-white">{{ Auth::user()->getInitials() }}</span></span>
    <h1 class="ml-[150px] sm:ml-[150px] mb-6 text-4xl mt-16">Hallo, <br>{{ $user->name }}</h1>
    </div>
        <h1 class="text-[40px] text-center mt-4">Ingeschreven activiteiten</h1>
        <div class="flex flex-col gap-5 bg-yellow-400 rounded-2xl w-[90%] h-[75%] mt-1 p-4 items-center">
        <div class="w-[100%] h-[40%] ">
            <div>
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle">
                                <table class="divide-y divide-gray-200 w-[100%]">
                                    <thead class="bg-gray-50 ">
                                    <tr class="">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activiteit</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locatie</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beschrijving</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eind</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eigen kosten</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min deelnemers</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max deelnemers</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($joinedActivities as $activity)
                                        <tr  class="hover:bg-[#ffe094] transition">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-5"><a href="/activity/{{ $activity->id }}" wire:navigate>{{ $activity->title }}</a></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->location }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->description }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->startTime }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->endTime }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@if($activity->cost != 0) {{ $activity->cost }} euro @endif</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->minParticipants }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->maxParticipants }}</td>
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
    </div>
    <h1 class="text-[40px] text-center mt-4">Alle activiteiten</h1>
    <div class="flex flex-col gap-5 bg-yellow-400 rounded-2xl w-[90%] h-[75%]  p-4 items-center ">
        <div class="w-[100%] h-[45%]">
            <div>
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle">
                                <table class="divide-y divide-gray-200 w-[100%]">
                                    <thead class="bg-gray-50 ">
                                    <tr class="">
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activiteit</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locatie</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beschrijving</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eind</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eigen kosten</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Min deelnemers</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Max deelnemers</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($activities as $activity)
                                        <tr  class="hover:bg-[#ffe094] transition">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-5"><a href="/activity/{{ $activity->id }}" wire:navigate>{{ $activity   ->title }}</a></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->location }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->description }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->startTime }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->endTime }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">@if($activity->cost != 0) {{ $activity->cost }} euro @endif</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->minParticipants }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $activity->maxParticipants }}</td>
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
    </div>
    <button @click="open = true" class="mt-4 underline text-yellow-400">Wachtwoord veranderen?</button>
<div x-show="open" @click.away="open = false" x-transition  class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
    <div class="bg-yellow-400 rounded-2xl min-w-[350px] w-[500px] h-[400px] m-[2.5%] flex">
        <button @click="open = false" class="fixed mt-[-50px] text-black font-bold text-[100px]">
            &times;
        </button>
        <livewire:update-password />
        {{--        <span class="inline-flex m-4 w-[150px] h-[150px] absolute items-center justify-center rounded-full bg-gray-500"><span class="font-medium text-[30px] leading-none text-white">{{ Auth::user()->getInitials() }}</span></span>--}}
        {{--        <h1 class="absolute ml-[200px] text-4xl mt-16">Hallo, <br>{{$user->name}}</h1>--}}
        {{--        <div>--}}
        {{--            <form action="#" class="w-[75%] h-[70%] mt-10 flex flex-col gap-4 pt-36 pl-5 mt-[25%] ml-[25%]">--}}
        {{--                <h3>Oud wachtwoord</h3>--}}
        {{--                <input type="text" class="w-[300px]" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">--}}
        {{--                <h3>Nieuwe wachtwoord</h3>--}}
        {{--                <input type="password" class="w-[300px]" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">--}}
        {{--                <input type="submit" class="bg-black text-white w-[100px]">--}}
        {{--            </form>--}}
        {{--        </div>--}}



    </div>
</div>
</div>
