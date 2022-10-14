<?php

namespace Chewbathra\Chewby\Tests\Datasets\Models;

use Chewbathra\Chewby\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;
}
