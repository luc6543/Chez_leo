<div>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <div class="flex items-center justify-between mt-6">
                    <h1 class="text-base font-semibold leading-6 text-gray-900" style="font-size: 50px">Activiteiten</h1>
                    <button wire:click="toggleShowPastActivities()"
                            type="button"
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded">
                        Ouwe Activiteiten
                    </button>

                </div>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">

            </div>
        </div>
        @if (session()->has('notActivated'))
            <div class="bg-yellow-100 mt-12 border-yellow-500 text-yellow-700 px-4 py-3" role="alert">
                <p class="font-bold">Oeps!</p>
                <p class="text-sm">Je account is nog niet geactiveerd!</p>
            </div>
        @endif
        @if (session()->has('tooLate'))
            <div class="bg-yellow-100 mt-12 border-yellow-500 text-yellow-700 px-4 py-3" role="alert">
                <p class="font-bold">U bent te laat!</p>
                <p class="text-sm">Deze activteit is al geweest of is vandaag!</p>
            </div>
        @endif
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="flex flex-wrap gap-[30px] justify-center">

                    @foreach ($activities as $activiteit)
                        <!-- Card with background color #f5af00 and text color white -->
                        <div class="w-[calc(100%-30px)] max-w-[360px] rounded-xl overflow-hidden shadow-lg bg-[#f5af00] mb-6">
                            <div class="p-32" style="background: url('{{ Vite::Asset('storage/app/'.$activiteit->img)}}')"></div>
                            <a href="/activity/{{ $activiteit->id }}" wire:navigate>
                                <div class="px-6 py-4 text-center">
                                    <p class="font-bold text-2xl mb-4 text-white">{{ $activiteit->title }}</p>
                                    <p class="text-white text-base">{{ $activiteit->description }}</p>
                                    <p class="text-white text-base">{{ $activiteit->startTime->format('d-m-Y') }}</p>
                                    <p class="text-white text-base">{{ $activiteit->endTime->format('d-m-Y') }}</p>
                                    <p class="text-white text-base">€{{ $activiteit->cost }}</p>
                                    <p class="text-white text-base">{{ $activiteit->participants->count() }} / {{ $activiteit->maxParticipants ?? "-" }} deelnemers</p>
                                </div>
                            </a>
                            <!-- Centered and larger "Inschrijven" button -->
                            <div class="px-5 pt-4 pb-2 flex justify-center">
                                @if(  $activiteit->participants->count() == $activiteit->maxParticipants)
                                        <button wire:click="toggleActivityParticipation({{$activiteit->id}})"
                                                type="button"
                                                class="inline-flex items-center justify-center w-full max-w-[calc(100%-40px)] rounded-md bg-gray-600 px-8 py-4 text-xl font-semibold text-white shadow-sm hover:bg-gray-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 mb-2.5">
                                            <svg class="-ml-0.5 mr-1.5 h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            vol
                                        </button>
                                 @else
                                @if($activiteit->participants->contains(Auth()->user()))
                                    <button wire:click="toggleActivityParticipation({{$activiteit->id}})"
                                            type="button"
                                            class="inline-flex mb-4 items-center justify-center w-full max-w-[calc(100%-40px)] rounded-md bg-red-600 px-8 py-4 text-xl font-semibold text-white shadow-sm hover:bg-red-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                        <svg class="-ml-0.5 mr-1.5 h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        Uitschrijven
                                    </button>
                                @else
                                    <button wire:click="toggleActivityParticipation({{$activiteit->id}})"
                                            type="button"
                                            class="inline-flex mb-4 items-center justify-center w-full max-w-[calc(100%-40px)] rounded-md bg-green-600 px-8 py-4 text-xl font-semibold text-white shadow-sm hover:bg-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                        <svg class="-ml-0.5 mr-1.5 h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                        Inschrijven
                                    </button>
                                @endif
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
