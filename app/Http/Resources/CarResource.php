<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class CarResource extends ApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = $this->resource->only([
              'id',
              'name',
              'year',
              'manufacturer_id'
        ]);
        $data['manufacturer'] = $this->resource->manufacturer?->name;
        return $data;
    }
}
