<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <title>Yaraku Book Planet</title>
    </head>
    <body class="mb-48">
        <nav class="flex justify-between items-center mb-4">
            {{-- company logo --}}
            <a href="/"
                ><img class="w-24" src="{{asset('images/logo.jpeg')}}" alt="" class="logo"
            /></a>
            
            {{-- Export books data --}}
            <form action="/export-book-data" method="get" id="downloadForm">
                <ul class="flex flex-row space-x-4 mr-6 text-sm">
                    <li class="flex flex-col">
                        <div>
                            <input type="checkbox" name="title" id="title" value="1">
                            <label for="title">Book Titles</label>
                        </div>
                        <div>
                            <input type="checkbox" name="author" id="author" value="1">
                            <label for="author">Authors</label>
                        </div>
                    </li>
                    <li class="flex flex-row space-x-4">
                        <button class="bg-zinc-700 text-white active:bg-zinc-600 text-xs px-4 py-2 rounded-full shadow hover:bg-zinc-800 hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="submit" name="format" value="csv"
                        >
                        Download CSV
                        </button>
                        <button class="bg-zinc-700 text-white active:bg-zinc-600 text-xs px-4 py-2 rounded-full shadow hover:bg-zinc-800 hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150" type="submit" name="format" value="xml"
                        >
                        Download XML
                        </button>
                    </li>
                </ul>
            </form>
        </nav>
        <main>
            @yield('content')
        </main>
    @include('flash-message')
    </body>
</html>