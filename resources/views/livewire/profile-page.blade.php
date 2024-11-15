<div class="flex flex-col mt-[200px] gap-5 justify-center items-center">
    <div class="bg-white rounded shadow w-fit">
        <span
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-500"><span
                class="font-medium leading-none text-white">{{ Auth::user()->getInitials() }}</span></span>
    </div>
    <div class=" sm:p-6 lg:p-8 bg-white rounded shadow w-fit">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold text-gray-900">Mijn reserveringen</h1>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Reserverings nummer</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tafel nummer</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Datum</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rekening</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Voldaan</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0"></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                        </tr>

                        <!-- More people... -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
