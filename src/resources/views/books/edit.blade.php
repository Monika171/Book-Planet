@extends('layout')

@section('content')

<div class="mt-24 max-w-lg mx-auto">
    <a href="/" class="inline-block text-black ml-4 mb-4">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <div class="bg-gray-50 border border-gray-200 p-10 rounded">
        <header class="text-center mb-10">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Book Info
            </h2>
            <p class="mb-4">Edit: {{$book->title}}</p>
        </header>

        <form method="POST" action="/books/{{$book->id}}">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label
                    for="title"
                    class="inline-block text-lg mb-2"
                    >Title</label
                >
                <span class="text-red-500"> *</span>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="title"
                    value="{{$book->title}}"
                    placeholder="Enter Book Title"
                />
                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="author" class="inline-block text-lg mb-2"
                    >Author</label
                >
                <span class="text-red-500"> *</span>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="author"
                    value="{{$book->author}}"
                    placeholder="Enter Author's Name"
                />
                @error('author')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6 text-center">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection