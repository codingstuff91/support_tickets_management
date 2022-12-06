<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $ticket->title }}
        </h2>
        <div class="flex">
            <p class="mt-2">Status : {{ $ticket->status }}</p>
            <p class="mt-2 ml-6">Priority : {{ $ticket->priority }}</p>
            <p class="mt-2 ml-4"> 
                @foreach ($categories as $category)
                    <p class="bg-green-300 rounded-xl px-2 py-2">{{ $category->name }}</p>
                @endforeach
            </p>
            <p class="mt-2 ml-4">
                @foreach ($labels as $label)
                    <p class="bg-lime-200 rounded-xl px-2 py-2">{{ $label->name }}</p>
                @endforeach
            </p>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-center">Description</h3>
            <div class="mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 bg-white border-b border-gray-200">
                    <p class="w-full my-8">{{ $ticket->description }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                    <label>Add a new comment here</label>
                    <textarea class="w-full rounded-lg" name="body" rows="2"></textarea>
                    @if ($errors->priority)
                        <p>{{ $errors->first('body') }}</p>
                    @endif                        
    
                    <input 
                        class="bg-green-200 py-4 px-4 rounded-lg" 
                        type="submit" 
                        value="Confirm"
                    >
                </form>
            </div>
        </div>
    </div>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-center">{{ $comments->count() }} Comments</h3>
            @foreach ($comments as $comment)
            <div class="p-6 bg-white border-b border-gray-200 flex">
                <div class="w-1/4 mr-4 text-center">
                    <p class="py-1">{{ $comment->user->name }}</p>
                    <p class="py-1">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <p>{{ $comment->body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>