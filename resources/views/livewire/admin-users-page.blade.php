<div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                    <tr>
                        <a href="/admin/add/users">
                        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 border border-orange-700 rounded" >
                            Voeg toe
                        </button>
                        </a>

                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                            Naam
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nummer</th>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-center  text-sm font-semibold text-gray-900">
                            Geactiveerd
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-100 bg-white">
                    @foreach($users as $user)

                        <tr class="hover:bg-[#ffe094] transition">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{$user->name}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <div class="mt-1 text-gray-500">{{$user->email}}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <div class="mt-1 text-gray-500">{{$user->phone}}</div>
                            </td>
                            @if($user->activated)

                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 flex justify-center">
                                    <button wire:click="toggleActivation({{$user}})"
                                            class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                        Active
                                    </button>
                                </td>

                            @else
                                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 flex justify-center">
                                    <button wire:click="toggleActivation({{$user}})"
                                            class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
                                        Inactive
                                    </button>
                                </td>
                            @endif


                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-center text-sm font-medium sm:pr-0 mr-4">
                                <a href="/admin/users/{{$user->id}}" class="text-indigo-600 hover:text-indigo-900">Edit<span
                                        class="sr-only">{{$user->name}}</span></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
