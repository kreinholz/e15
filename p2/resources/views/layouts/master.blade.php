<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='/css/word.css' rel='stylesheet'>
        <title>@yield('title')</title>
    </head>
    <body>
        <div class='content'>
        <header>
            <div class="title m-b-md">
                Project 2 - Word Finder
            </div>
        </header>

        <section>
            @yield('content')
        </section>

        <footer>
            &copy; {{ date('Y') }} Kevin Reinholz
        </footer>
    </div>
    </body>
</html>