<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ $ticket->title }}
            </h2>
            <div class="flex">
                <p class="mt-2 mr-2">Status : {{ $ticket->status }}</p>
                <p class="mt-2 ml-2">Priority : {{ $ticket->priority }}</p>
            </div>
            <div class="flex">
                <p>Categories :</p>
                @foreach ($categories as $category)
                    <p class="ml-2">{{ $category->name }}</p>
                @endforeach
            </div>
            <div class="flex">
                <p>Labels :</p>
                @foreach ($labels as $label)
                    <p class="ml-2">{{ $label->name }}</p>
                @endforeach
            </div>
        </div>
        <div>
            @can('update', $ticket)
                <div>
                    <button class="text-white ml-2 mt-2 max-h-12 rounded-xl bg-blue-500 px-4 py-2">
                        <a href="{{ route('tickets.edit', $ticket->id) }}">Edit Ticket</a>
                    </button>
                </div>
            @endcan
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-center text-xl font-bold">Description</h3>
            <div class="mt-2 bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="px-6 bg-white border-b border-gray-200">
                    <p class="w-full my-8">{{ $ticket->description }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 rounded-lg">
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                    <label>Add a new comment here</label>
                    <textarea class="w-full rounded-lg" name="body" rows="2"></textarea>
                    @if ($errors->priority)
                        <p>{{ $errors->first('body') }}</p>
                    @endif                        
    
                    <input 
                        class="bg-green-200 py-2 px-2 rounded-xl font-xl font-semibold" 
                        type="submit" 
                        value="Confirm"
                    >
                </form>
            </div>
        </div>
    </div>
    <div class="py-2 rounded-lg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-center text-xl">{{ $comments->count() }} Comments</h3>
            @foreach ($comments as $comment)
            <div class="p-6 bg-white border-b border-gray-200 flex rounded-lg">
                <div class="w-1/4 mr-4 text-center text-bold">
                    <p class="py-1">{{ $comment->user->name }}</p>
                    <p class="py-1 italic">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <p>{{ $comment->body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>