<?php

namespace Tests\Unit;

use App\Models\Manufacturer;
use App\Services\ManufacturerService;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\TestCase;

class ManufacturerServiceTest extends TestCase
{
    public function testCanDeleteManufacturer()
    {
        $hasManyMock = $this->createMock(HasMany::class);
        $hasManyMock->method('get')->willReturn(collect());

        // Create a mock of the Manufacturer model
        $manufacturer = $this->getMockBuilder(Manufacturer::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Mock the cars method to return the HasMany relationship mock
        $manufacturer->method('cars')->willReturn($hasManyMock);

        $service = new ManufacturerService();
        // Assert that a manufacturer without cars can be deleted
        $this->assertTrue($service->canDelete($manufacturer));
    }
}
