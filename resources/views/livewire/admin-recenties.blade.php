<div class="container mx-auto p-4 mt-24">
    <h1 class="text-2xl font-bold mb-4">Admin Reviews</h1>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @if($reviews->isEmpty())
            <p class="text-gray-700">No reviews found.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recensie tekst</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sterren</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gemaakt op</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangepast op</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div x-data="{ expanded: false }">
                                    <p x-show="!expanded">
                                        {{ Str::limit($review->review, 255) }}
                                        @if(strlen($review->review) > 255)
                                            <button class="text-blue-500 hover:underline ml-2" @click="expanded = true">Lees meer</button>
                                        @endif
                                    </p>
                                    <p x-show="expanded">
                                        {{ $review->review }}
                                        <button class="text-blue-500 hover:underline ml-2" @click="expanded = false">Lees minder</button>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->rating }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $review->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ date('d/m/Y H:i', strtotime($review->created_at)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ date('d/m/Y H:i', strtotime($review->updated_at)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><button>Verwijder</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
