<tr>
    @foreach($columns as $key => $display)
        <td @if(isset($display["centered"]) && $display["centered"]) class="chewby__centered" @endif>
            @if (Arr::accessible($display["render"]))
                {!!call_user_func($display["render"], $model)!!}
            @else
                {{$model->getAttributes()[$key]}}
            @endif
        </td>
    @endforeach
    <td class="chewby__table__actions">
        <a href="#">
            <x-icon-edit />
        </a>
        <form action="{{route($route, ["id" => $model->id])}}"
              method="POST"
              loader-on-submit=""
        >
            @method('delete')
            @csrf
            <button class="chewby__button chewby__button--icon">
                <x-icon-trash-2 class="chewby__icon--red" />
            </button>
        </form>
    </td>
</tr>
