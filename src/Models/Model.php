<?php

namespace Chewbathra\Chewby\Models;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public int $id;
    public bool $online;
    public \DateTime $online_from;
    public \DateTime $online_to;
    public string $title;
}
