<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1>New ticket creation</h1>

                    <form action="{{ route('tickets.store') }}" method="post">
                        @csrf

                        <div>
                            <label>Title</label>
                            <input type="text" name="title" value="{{ old('title') }}">
                            @if ($errors->title)
                                <p>{{ $errors->first('title') }}</p>
                            @endif
                        </div>
                        
                        <div>
                            <label>Message</label>
                            <textarea name="description" cols="30" rows="10">{{ old('description') }}</textarea>
                            @if ($errors->description)
                                <p>{{ $errors->first('description') }}</p>
                            @endif
                        </div>
                        
                        <div>
                            <label>Labels</label>
                            @foreach ($labels as $label)
                                <label>{{ $label->name }}</label>
                                <input type="checkbox" name="labels[]" value="{{ $label->id }}">
                            @endforeach
                        </div>
                        
                        <div>
                            <label>Categories</label>
                            @foreach ($categories as $category)
                                <label>{{ $category->name }}</label>
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            @endforeach
                        </div>

                        <div>
                            <label>Priority</label>
                            <select name="priority">
                                <option value="">Choisir une option</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                            </select>
                            @if ($errors->priority)
                                <p>{{ $errors->first('priority') }}</p>
                            @endif
                        </div>

                        <input type="submit" value="Confirm">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>