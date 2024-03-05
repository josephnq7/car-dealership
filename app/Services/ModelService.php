<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class ModelService
{
    public abstract function canDelete(Model $object);
}
