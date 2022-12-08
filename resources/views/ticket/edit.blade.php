<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit ticket') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('tickets.update',  $ticket->id) }}" method="post">
                        @csrf

                        @method('PATCH')

                        <div class="mt-2">
                            <label class="text-xl text-semibold">Title</label>
                            <input 
                            type="text" 
                            name="title"
                            class="w-full rounded-lg mt-2"
                            value="{{ $ticket->title }}">

                            @if ($errors->title)
                                <p>{{ $errors->first('title') }}</p>
                            @endif
                        </div>
                        
                        <div class="mt-2">
                            <label>Message</label>
                            <textarea 
                                name="description" 
                                cols="30" 
                                rows="3"
                                class="w-full rounded-lg mt-2">
                                {{ $ticket->description }}
                            </textarea>

                            @if ($errors->description)
                                <p>{{ $errors->first('description') }}</p>
                            @endif
                        </div>

                        <div class="mt-2">
                            <label>Priority</label>
                            <select name="priority" class="block mt-2 rounded-lg">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority }}" {{ $ticket->priority == $priority ? 'selected' : '' }}>{{ $priority }}</option>
                                @endforeach
                            </select>
                            @if ($errors->priority)
                                <p>{{ $errors->first('priority') }}</p>
                            @endif
                        </div>

                        <div class="mt-2">
                            <label>Categories</label>
                            <label class="block">
                                @foreach ($categories as $category)
                                    <input type="checkbox" class="mx-2" name="categories[]" value="{{ $category->id }}" {{ $ticketCategories->contains($category) ? 'checked' : ''}}>
                                    {{ $category->name }}
                                @endforeach
                            </label>
                        </div>

                        <div class="mt-2">
                            <label>Labels</label>
                            <label class="block">
                                @foreach ($labels as $label)
                                    <input type="checkbox" class="mx-2" name="categories[]" value="{{ $label->id }}" {{ $ticketLabels->contains($label) ? 'checked' : ''}}>
                                    {{ $label->name }}
                                @endforeach
                            </label>
                        </div>

                        <input type="submit" value="Confirm" class="mt-4 bg-green-400 px-4 py-2 rounded-lg">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>