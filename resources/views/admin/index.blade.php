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

                </div>
            </div>
        </div>
    </div>
</x-app-layout>