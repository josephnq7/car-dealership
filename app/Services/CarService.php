<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CarService extends ModelService
{
    public function searchByManufacturer(string $input = ''): Collection|array
    {
        return Car::query()->join('manufacturers AS m', 'cars.manufacturer_id', '=', 'm.id')
            ->select('cars.*')
            ->when($input, function ($query) use ($input) {
                $query->where('m.name', 'LIKE', "%$input%");
            })->get();
    }

    public function canDelete(Model $object): bool
    {
        // TODO: may be we don't allow to delete the car that on purchasing
        return true;
    }
}
