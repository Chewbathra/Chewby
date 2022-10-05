<header class="header">
    <div class="header__infos">
        <h1 class="header__title">
            <x-icon-globe />
            {{config("app.name")}}
        </h1>
        <h4 class="header__subtitle">@stack('header.subtitle')</h4>

    </div>
    <div class="header__actions">
{{--        <ul class="header__breadcrumb">--}}
{{--            @foreach ($breadcrumbItems as $key => $path)--}}
{{--            <li>--}}
{{--                @if ($loop->last)--}}
{{--                {{$key}}--}}
{{--                @else--}}
{{--                <a href="{{$path}}">{{$key}}</a>--}}
{{--                @endif--}}
{{--            </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
        <div class="actions__buttons">
            @dump(Session::has('message'))
        </div>
    </div>
</header>

{{-- <div class="alerts">

    @if(Session::has('alert'))
        @include('components.alert', [
            "content" => "Salut c'est moi",
            "type" => "success"
        ])
    @endif
</div> --}}
