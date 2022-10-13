@extends('chewby::layouts.app')


@section('content')
    {{--    {{DB::getSchemaBuilder()->getColumnType('posts', 'id')}}--}}
    {{--    @dump(get_class_methods($model))--}}
    {{--    @dump($model->getTable())--}}
    @dump($model)
@endsection
