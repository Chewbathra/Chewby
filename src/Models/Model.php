<?php

namespace Chewbathra\Chewby\Models;

use Illuminate\Database\Eloquent\Builder;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'online_from' => 'datetime',
        'online_until' => 'datetime',
    ];

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public function scopeOnline(Builder $query): Builder
    {
        return $query->where([
            ['online', '=', 1],
            ['online_from', '<=', now()],
            ['online_until', '>=', now()],
        ]);
    }
}
