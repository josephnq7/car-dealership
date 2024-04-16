<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Customer;
use App\Services\CarService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class CustomerController extends ApiController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model = Customer::class;

    protected function rules(string $method = 'create', $object = null): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function __construct(CarService $service)
    {
        $this->service = $service;
        parent::__construct();
    }
}
