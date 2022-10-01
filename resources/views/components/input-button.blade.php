<div @class([
        'chewby__input', 
        'chewby__input--button',
        $attributes["class"]
    ])>
    <input
        {{$attributes->except(["class", "button-name"])}}
    />
    <button class="input__button">{{$attributes["button-name"] ?? "Send"}}</button>
</div>

