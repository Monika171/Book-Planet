@extends('layout')

@section('content')
<h1>{{$heading}}</h1>

@unless(count($books) == 0)

@foreach($books as $book)
<h2>
    <a href="/books/{{$book['id']}}">{{$book['title']}}</a>
</h2>
<p>
    {{$book['author']}}
</p>
@endforeach

@else
<p>No Books Found</p>
@endunless

@endsection