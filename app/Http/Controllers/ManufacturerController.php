<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Manufacturer;
use App\Services\ManufacturerService;
use App\Services\ModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ManufacturerController extends ApiController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model = Manufacturer::class;

    protected function rules(string $method = 'create', $object = null): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function __construct(ManufacturerService $service)
    {
        $this->service = $service;
    }
}
