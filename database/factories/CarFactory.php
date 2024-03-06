<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{

    protected $model = Car::class;

    public function definition(): array
    {
        $manufacturer = fake()->boolean ? (Manufacturer::inRandomOrder()->dontCache()->first() ?? ManufacturerFactory::new()->create()) : null;

        return [
            'name' => fake()->name,
            'year' => fake()->numberBetween(1990, 2024),
            'manufacturer_id' => $manufacturer instanceof Manufacturer ? $manufacturer->id : null,
        ];
    }

    public function forManufacturer(int $manufacturerId): static
    {
        return $this->state(function() use ($manufacturerId) {
            $manufacturer = Manufacturer::findOrFail($manufacturerId);
            return [
                'manufacturer_id' => $manufacturer->id,
            ];
        });
    }
}
