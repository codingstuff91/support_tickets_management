<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>{{ $ticket->title }}</h1>
                    <p>{{ $ticket->description }}</p>
                    <p>{{ $ticket->status }}</p>
                    <p>{{ $ticket->priority }}</p>
                    
                    @foreach ($labels as $label)
                        <p>{{ $label->name }}</p>
                    @endforeach

                    @foreach ($categories as $category)
                        <p>{{ $category->name }}</p>
                    @endforeach

                    <h2>Comments</h2>
                    <h3>Add a new comment</h3>
                    <form action="{{ route('comment.store') }}" method="post">
                        @csrf
                        <label>Type your comment</label>
                        <textarea name="body" cols="30" rows="10"></textarea>

                        <input type="submit" value="Confirm">
                    </form>

                    @foreach ($comments as $comment)
                        <p>{{ $comment->body }}</p>
                        <p>{{ $comment->user->name }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>