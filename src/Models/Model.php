<?php

namespace Chewbathra\Chewby\Models;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
//    public int $id;
//    public bool $online;
//    public \DateTime $online_from;
//    public \DateTime $online_until;
//    public string $title;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'online_from' => 'datetime',
        'online_until' => 'datetime',
    ];
}
