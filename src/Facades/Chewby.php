<?php

namespace Chewbathra\Chewby\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chewbathra\Chewby\Chewby
 */
class Chewby extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Chewbathra\Chewby\Chewby::class;
    }
}
