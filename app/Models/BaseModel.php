<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

abstract class BaseModel extends Model
{
    use QueryCacheable;

    public $cacheFor  = -1; // // cache time, in seconds (-1: forever)

    protected static function getModelName(): string
    {
        return class_basename(static::class);
    }

    protected function cacheTagsValue()
    {
        return [static::getModelName()];
    }

    /**
     * A cache prefix string that will be prefixed
     * on each cache key generation.
     *
     * @return string
     */
    protected function cachePrefixValue()
    {
        return static::getModelName(). '_';
    }

    public static function boot()
    {
        parent::boot();

        // Clear caching by expiring the model's tags upon create/update/delete.

        static::created(function ($item) {
            static::flushModelCaches($item);
        });

        static::updated(function ($item) {
            static::flushModelCaches($item);
        });

        static::deleted(function ($item) {
            static::flushModelCaches($item);
        });
    }

    /**
     * Clears the cache for this model. Extend this method to clear additional caches.
     */
    protected static function flushModelCaches(BaseModel $item): void
    {
        $modelName = static::getModelName();

        $item::class::flushQueryCache([$modelName, $modelName . ":relation"]);
    }
}
