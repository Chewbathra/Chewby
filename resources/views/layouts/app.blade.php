<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @livewireStyles
    @vite(["packages/Chewbathra/Chewby/resources/css/app.scss"])
</head>
<body>
@include('chewby::layouts.navigation')
<main>
    @include('chewby::layouts.header')
    <section class="content">
        @yield('content')
    </section>
    {{-- <aside>
        @include('aside')
    </aside> --}}
</main>
@include('chewby::layouts.footer')
</body>
@livewireScripts
@vite(["packages/Chewbathra/Chewby/resources/js/app.ts"])
</html>
