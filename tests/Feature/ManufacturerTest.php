<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Manufacturer;
use Database\Factories\CarFactory;
use Database\Factories\ManufacturerFactory;
use Database\Seeders\CarSeeder;
use Database\Seeders\ManufacturerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ManufacturerTest extends TestCase
{
    use RefreshDatabase;

    protected Manufacturer $manufacturer;
    protected Collection $manufacturers;
    protected string $url;
    protected string $seederClass;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(ManufacturerSeeder::class);
        $this->url = 'api/manufacturer';
        $this->manufacturer = Manufacturer::inRandomOrder()->first();
        $this->manufacturers = Manufacturer::all();
    }


    public function testStore(): void
    {
        $data = ManufacturerFactory::new()->raw();
        $response = $this->post($this->url, $data);

        $response->assertCreated();
    }

    public function testStoreFailed(): void
    {
        $data = ManufacturerFactory::new()->raw();
        unset($data['name']);
        $response = $this->post($this->url, $data);

        $response->assertUnprocessable();
    }

    public function testShow(): void
    {
        $response = $this->get($this->url . "/{$this->manufacturer->id}");

        $response->assertStatus(200)
            ->assertJson([
                 'data' => [
                     'id' => $this->manufacturer->id,
                     'name' => $this->manufacturer->name,
                 ],
            ]);
    }

    public function testIndex(): void
    {
        $response = $this->get($this->url);

        $response->assertStatus(200);
        $data = $response->decodeResponseJson();

        $this->assertEquals($data['meta']['total'], $this->manufacturers->count());
    }

    public function testUpdate(): void
    {
        $data = $this->manufacturer->toArray();
        $data['name'] = 'updated';
        $response = $this->put($this->url . "/{$this->manufacturer->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                 'data' => [
                     'id' => $this->manufacturer->id,
                     'name' => 'updated',
                 ],
         ]);
    }

    public function testCannotDestroy(): void
    {
        CarFactory::new()->forManufacturer($this->manufacturer->id)->create();
        $response = $this->deleteJson(
            $this->url . "/{$this->manufacturer->id}"
        );
        $response->assertStatus(422);
    }

    public function testCanDestroy(): void
    {
        $manufacturer = ManufacturerFactory::new()->create();
        $response = $this->deleteJson(
            $this->url . "/{$manufacturer->id}"
        );
        $response->assertStatus(204);
    }
}
