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
                <div class="p-6 w-full bg-white border-b border-gray-200 flex flex-col items-center justify-center">
                    <h1 class="text-xl text-bold my-4 text-center">Assign ticket to an agent</h1>

                    <form 
                    action="{{ route('admin.assign_ticket', $ticket->id) }}" 
                    method="post"
                    class="flex flex-col">
                        @csrf

                        @method('PUT')

                        <select name="agent_id" class="w-full rounded-lg">
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                            @endforeach
                        </select>

                        <input type="submit"
                            value="Confirm"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg mt-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>