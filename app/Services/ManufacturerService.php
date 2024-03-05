<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class ManufacturerService extends ModelService
{

    public function canDelete(Manufacturer|Model $object): bool
    {
        //don't allow to delete a manufacturer if there is a car assigned to it
        return !$object->cars()->count();
    }
}
