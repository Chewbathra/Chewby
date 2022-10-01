@extends('chewby::layouts.app')


@section('content')
    <x-chewby::status />
    <br>
    <x-chewby::input type="password" name="password"/>
    <br>
    <br>
    <x-chewby::input-button type="password" name="password"/>
    <x-chewby::loader display/>
@endsection
