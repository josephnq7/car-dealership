<?php

namespace Tests\Feature;

use App\Models\Car;
use Database\Factories\CarFactory;
use Database\Seeders\CarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    protected Car $car;
    protected Collection $cars;
    protected string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CarSeeder::class);
        $this->url = 'api/car';
        $this->car = Car::inRandomOrder()->first();
        $this->cars = Car::all();
        $this->withoutMiddleware('api');
    }


    public function testStore(): void
    {
        $data = CarFactory::new()->raw();
        $response = $this->post($this->url, $data);

        $response->assertCreated();
    }

    public function testStoreFailed(): void
    {
        $data = CarFactory::new()->raw();
        unset($data['name']);
        $response = $this->post($this->url, $data);

        $response->assertUnprocessable();
    }

    public function testShow(): void
    {
        $response = $this->get($this->url . "/{$this->car->id}");

        $response->assertStatus(200)
            ->assertJson([
                 'data' => [
                     'id' => $this->car->id,
                     'name' => $this->car->name,
                     'year' => $this->car->year,
                     'manufacturer_id' => $this->car->manufacturer_id,
                 ],
            ]);
    }

    public function testIndex(): void
    {
        $response = $this->get($this->url);

        $response->assertStatus(200);
        $data = $response->decodeResponseJson();


//        $this->assertEquals($data['meta']['total'], $this->cars->count()); //for pagination
        $this->assertEquals(count($data['data']), $this->cars->count());

    }

    public function testUpdate(): void
    {
        $data = $this->car->toArray();
        $data['name'] = 'updated';
        $response = $this->put($this->url . "/{$this->car->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                 'data' => [
                     'id' => $this->car->id,
                     'name' => 'updated',
                     'year' => $this->car->year,
                     'manufacturer_id' => $this->car->manufacturer_id,
                 ],
         ]);
    }

    public function testDestroy(): void
    {
        $response = $this->deleteJson(
            $this->url . "/{$this->car->id}"
        );
        $response->assertStatus(204);
    }
}
