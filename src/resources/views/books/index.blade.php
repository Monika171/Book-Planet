@extends('layout')

@section('content')
@include('partials._hero')
@include('partials._search')

<div class="grid gap-4 space-y-4 md:space-y-0 max-w-3xl mx-auto">

@unless(count($books) == 0)

@foreach($books as $book)
    <div class="bg-gray-50 border border-gray-200 rounded p-6">
        <div class="flex">
            <div>
                <h3 class="text-2xl">
                    <a href="/books/{{$book->id}}">{{$book->title}}</a>
                </h3>
                <div class="text-xl font-bold mb-4">{{$book->author}}</div>
            </div>
        </div>
    </div>
@endforeach

@else
<p>No Books Found</p>
@endunless

</div>

<div class="mt-6 p-4 mx-5">
    {{$books->links('pagination::tailwind')}}
</div>
@endsection