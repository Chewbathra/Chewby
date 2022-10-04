<div {{$attributes->class([
    "chewby__notification",
    "chewby__notification--danger" => isset($attributes['danger']),
//    "chewby__notification",
])}}>
    <x-icon-bell class="chewby__notification__icon"/>
    <span class="chewby__notification__content">
            {{$slot}}
    </span>
    <x-icon-x class="chewby__notification__icon chewby__notification__icon--close"/>
</div>
