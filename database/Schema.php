<?php

namespace Chewbathra\Chewby\Database;

use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema as BaseSchema;

class Schema extends BaseSchema
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string|null  $name
     * @return Builder
     */
    public static function connection($name): Builder
    {
        return static::customizedSchemaBuilder($name);
    }

    /**
     * Get a schema builder instance for the default connection.
     *
     * @return Builder
     */
    protected static function getFacadeAccessor(): Builder
    {
        return static::customizedSchemaBuilder();
    }

    /**
     * Retrieves an instance of the schema `Builder` with a customized `Blueprint` class.
     *
     * @param  string|null  $name
     * @return Builder
     */
    public static function customizedSchemaBuilder(string|null $name = null): Builder
    {
        /** @var Builder $builder */
        $builder = static::$app['db']->connection($name)->getSchemaBuilder();
        $builder->blueprintResolver(static fn ($table, $callback) => new Blueprint($table, $callback));

        return $builder;
    }
}
