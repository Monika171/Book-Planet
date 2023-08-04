@extends('layout')

@section('content')
@include('partials._hero')
@include('partials._search')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

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
@endsection