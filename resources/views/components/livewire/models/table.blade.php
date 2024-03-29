<div class="chewby__models__table">
    <a href="{{route($createRoute)}}" class="chewby__button">Add</a>
    <form action="#" method="GET" class="chewby___table__search">
        <x-chewby::input type="text" name="search" placeholder="Search" wire:model.debounce.200ms="search"/>
    </form>
    <div class="chewby__table__container">
        <x-chewby::loader wire:loading.class="chewby__loader--display"/>
        <table class="chewby__table">
            <thead class="chewby__table__header">
            <tr>
                @foreach($columns as $key => $display)
                    <th wire:click="setOrder('{{$key}}')" @if(isset($display["centered"]) && $display["centered"]) class="chewby__centered" @endif>
                    <span>{{$display["label"]}}
                        @if ($orderTerm == $key)
                            @if ($orderDirection == "ASC")
                                <x-icon-chevron-down class="chewby__icon--white"/>
                            @else
                                <x-icon-chevron-up class="chewby__icon--white"/>
                            @endif
                        @endif
                    </span>
                    </th>
                @endforeach
                <th></th>
            </tr>
            </thead>
            <tbody class="chewby__table__body">
            @foreach ($models as $model)
                @livewire('model-row', ["model" => $model, "columns" => $columns], key($model->id))
            @endforeach
            </tbody>
        </table>
    </div>
    {{$models->links()}}
</div>
