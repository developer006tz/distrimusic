<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderServicesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_order_services(): void
    {
        $order = Order::factory()->create();
        $service = Service::factory()->create();

        $order->service()->attach($service);

        $response = $this->getJson(route('api.orders.services.index', $order));

        $response->assertOk()->assertSee($service->name);
    }

    /**
     * @test
     */
    public function it_can_attach_services_to_order(): void
    {
        $order = Order::factory()->create();
        $service = Service::factory()->create();

        $response = $this->postJson(
            route('api.orders.services.store', [$order, $service])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $order
                ->service()
                ->where('services.id', $service->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_services_from_order(): void
    {
        $order = Order::factory()->create();
        $service = Service::factory()->create();

        $response = $this->deleteJson(
            route('api.orders.services.store', [$order, $service])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $order
                ->service()
                ->where('services.id', $service->id)
                ->exists()
        );
    }
}
