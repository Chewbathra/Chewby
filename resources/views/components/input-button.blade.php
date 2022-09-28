<div @class([
        'chewby__input', 
        'chewby__input--button',
        $attributes["class"]
    ])>
    @php
    @endphp
    <input
        {{$attributes->except(["class"])}}
    />
    <button class="input__button">Envoyer</button>
</div>

