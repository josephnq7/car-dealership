<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CarService extends ModelService
{

    public function canDelete(Model $object): bool
    {
        // TODO: may be we don't allow to delete the car that on purchasing
        return true;
    }
}
