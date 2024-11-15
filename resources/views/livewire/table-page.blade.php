<div>
    <div class="bg-gray-900 py-10">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="text-base font-semibold text-white">Tafels</h1>
                <button wire:click="openModal"
                    class="bg-yellow-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-yellow-400">
                    Voeg tafel toe
                </button>
            </div>

            <table class="min-w-full divide-y divide-gray-700 mt-8">
                <thead>
                    <tr>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Tafelnummer</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-white">Stoelen</th>
                        <th class="py-3.5"></th>
                        <th class="py-3.5"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach ($tables as $table)
                        <tr>
                            <td class="px-3 py-4 text-sm text-gray-300">{{ $table->table_number }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-300">{{ $table->chairs }}</td>
                            <td class="text-right">
                                <button wire:click="edit({{ $table->id }})"
                                    class="bg-blue-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-blue-400">Verander</button>
                            </td>
                            <td class="text-right">
                                <button wire:click="delete({{ $table->id }})"
                                    class="bg-red-500 px-3 py-2 text-sm font-semibold text-white rounded-md hover:bg-red-400">Verwijder</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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