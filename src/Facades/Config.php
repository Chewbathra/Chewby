<?php

namespace Chewbathra\Chewby\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chewbathra\Chewby\Config
 */
class Config extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Chewbathra\Chewby\Config::class;
    }
}
