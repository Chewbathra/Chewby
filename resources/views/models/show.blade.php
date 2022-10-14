@extends('chewby::layouts.app')


@section('content')
    <form action="{{route(\Chewbathra\Chewby\Facades\Chewby::routeNameForModel($model, 'update'), ['id' => $model->id])}}" method="POST">
        @method("patch")
        @foreach(array_filter($model->getAttributes(), fn($key) => !in_array($key, $model->getHidden()), ARRAY_FILTER_USE_KEY) as $attribute => $value)
            @switch($types[$attribute])
                @case('string')
                    <label for="chewby__input__{{$attribute}}">{{$attribute}}</label>
                    <textarea name="{{$attribute}}" id="chewby__input__{{$attribute}}" cols="30"
                              rows="5">{{$value}}</textarea>
                    @break
                @case('timestamp')
                @case('dateTime')
                    <label for="chewby__input__{{$attribute}}">{{$attribute}}</label>
                    <input type="datetime-local" id="chewby__input__{{$attribute}}" name="{{$attribute}}"
                           value="{{$value}}">
                    @break
                @case('boolean')
                    <label for="chewby__input__{{$attribute}}">{{$attribute}}</label>
                    <input type="checkbox" id="chewby__input__{{$attribute}}" name="{{$attribute}}"
                        @checked($value)>
                    @break
                @default
                    @break
            @endswitch
            <br>
        @endforeach
        <button class="chewby__button">Enregistrer les modifications</button>
    </form>
@endsection
