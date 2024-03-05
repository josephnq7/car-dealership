<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CarController extends ApiController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model = Car::class;

    protected function rules(string $method = 'create', $object = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
        ];
    }
}
