@extends('chewby::layouts.app')


@section('content')
    <x-chewby::status online/>
    <br>
    <x-chewby::input type="password" name="password"/>
    <br>
    <br>
    <x-chewby::input-button type="password" name="password"/>
    <x-chewby::loader/>
{{--    <x-chewby::notification danger>--}}
{{--        L'article a bien été supprimé--}}
{{--    </x-chewby::notification>--}}
    <x-chewby::notification>
        L'article a bien été supprimé
    </x-chewby::notification>
@endsection
