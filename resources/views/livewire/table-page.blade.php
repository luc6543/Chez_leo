<div>
    <div class="bg-white py-10 mt-16">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-base font-semibold text-white">Tafels</h1>
                <button wire:click="openModal"
                    class="bg-blue-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-blue-600">
                    Voeg tafel toe
                </button>
            </div>
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flow-root">
                    <div class="-my-2 overflow-x-auto">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg mt-2">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Tafelnummer</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Stoelen</th>
                                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>
                                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-6"></th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y w-full divide-gray-200 bg-white">
                                        @foreach($tables as $table)
                                            <tr class="w-full">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $table->table_number }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ $table->chairs }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    <button wire:click="edit({{ $table->id }})"
                                                        class="bg-green-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-green-600">Verander
                                                    </button>
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    <button wire:click="delete({{ $table->id }})"
                                                        x-data="{ isDeleting: false }" @click="isDeleting = true"
                                                        :disabled="isDeleting"
                                                        class="bg-red-700 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-red-600">Verwijder
                                                    </button>
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
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg p-6 w-1/3">
                <h2 class="text-lg font-semibold mb-2">
                    {{ $tableId ? 'Verander deze tafel' : 'Maak een tafel aan' }}
                </h2>

                @if (session()->has('error'))
                    <div class="alert alert-danger text-red-500">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="store" class="mt-2">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tafelnummer</label>
                        <input wire:model.defer="table_number" type="number" min="1"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        </input>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Stoelen</label>
                        <input wire:model.defer="chairs" type="number" min="1" max="6"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        </input>
                    </div>
                    <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md">Opslaan</button>
                    <button type="button" wire:click="closeModal"
                        class="ml-2 bg-gray-500 text-white px-4 py-2 rounded-md">Annuleer</button>
                </form>
            </div>
        </div>
    @endif
</div>