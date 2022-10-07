<?php

namespace Chewbathra\Chewby\Tests\Datasets\Models;

use Chewbathra\Chewby\Models\Model;
use Chewbathra\Chewby\Tests\Datasets\Factory\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestPost extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new PostFactory();
    }
}
