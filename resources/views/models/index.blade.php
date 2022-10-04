@extends('chewby::layouts.app')


@section('content')
    @livewire('model-table', ["resource" => $resource])
@endsection
