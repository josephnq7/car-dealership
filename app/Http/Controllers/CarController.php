<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CarController extends ApiController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model = Car::class;

    protected string $resourceModel = CarResource::class;

    protected function rules(string $method = 'create', $object = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'manufacturer_id' => 'nullable|integer|exists:manufacturers,id',
        ];
    }

    public function __construct(CarService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    public function index()
    {
        $this->query->with('manufacturer');
        return parent::index();
    }
}
