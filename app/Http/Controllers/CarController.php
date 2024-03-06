<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

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
        $this->query->with('manufacturer', function ($query) {
            return $query->cacheTags([$this->getModelTagName() . ':relation',]);
        });
        return parent::index();
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        //TODO: refactor this to handle different search criteria
        $this->query->join('manufacturers AS m', 'cars.manufacturer_id', '=', 'm.id')
            ->select('cars.*')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('m.name', 'LIKE', "%$keyword%");
            });
        return parent::index();
    }
}
