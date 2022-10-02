<?php

namespace Chewbathra\Chewby\Models;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public bool $online;

    public \DateTime $online_from;
}
