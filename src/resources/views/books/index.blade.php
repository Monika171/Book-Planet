@extends('layout')

@section('content')
@include('partials._hero')
@include('partials._search')
<div class="grid gap-4 space-y-4 md:space-y-0 max-w-3xl mx-auto mt-5 mb-20">

@unless(count($books) == 0)

@include('partials._sort')
@foreach($books as $book)
    <div class="bg-gray-50 border border-gray-200 rounded p-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold">
                    <a href="/books/{{$book->id}}">{{$book->title}}</a>
                </h3>
                <div class="text-base">by {{$book->author}}</div>
            </div>
            <ul class="flex space-x-6 text-sm">
                <li>
                    <a href="/books/{{$book->id}}/edit">
                        <i class="fa-solid fa-pencil"></i><br>
                        <span class="text-xs text-gray-500"> Edit</span>    
                    </a>
                </li>
                <li>
                    <form method="POST" action="/books/{{$book->id}}">
                    @csrf
                    @method('DELETE')
                        <button><i class="fa-solid fa-trash"></i><br>
                            <span class="text-xs text-gray-500"> Delete</span>
                        </button>             
                    </form>
                </li>
            </ul>
        </div>
    </div>
@endforeach

@else
<p>No Books Found</p>
@endunless

</div>

<div class="mt-6 p-4 mx-5">
    {{$books->appends(request()->query())->links('pagination::tailwind')}}
</div>
@include('partials._footer')
@endsection