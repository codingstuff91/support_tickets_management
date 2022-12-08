<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Support Tickets') }}
        </h2>
        <div>
            <button class="bg-green-500 py-2 px-4 rounded-lg text-white">
                <a href="{{ route('tickets.create') }}">Create a ticket</a>
            </button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg mt-2">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Title</th>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Description</th>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Status</th>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Priority</th>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Categories</th>
                                <th class="mx-10 border-2 border-gray-400 p-1 bg-blue-600 text-white">Labels</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <td class="text-center p-2 border-2 border-gray-400"><a href="{{ route('tickets.show', $ticket->id) }}">{{ $ticket->title }}</a></td>
                                <td class="text-center p-2 border-2 border-gray-400">{{ strlen($ticket->description) > 60 ? substr($ticket->description,0,60) : $ticket->description }}...</td>
                                <td class="text-center p-2 border-2 border-gray-400">{{ $ticket->status }}</td>
                                <td class="text-center p-2 border-2 border-gray-400">{{ $ticket->priority }}</td>
                                <td class="text-center p-2 border-2 border-gray-400">
                                    @foreach ($ticket->categories as $category)
                                        <p>{{ $category->name }}</p>
                                    @endforeach
                                </td>
                                <td class="text-center p-2 border-2 border-gray-400">
                                    @foreach ($ticket->labels as $label)
                                        <p>{{ $label->name }}</p>
                                    @endforeach
                                </td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>