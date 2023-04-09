<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceOrdersTest extends TestCase
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
    public function it_gets_service_orders(): void
    {
        $service = Service::factory()->create();
        $order = Order::factory()->create();

        $service->orders()->attach($order);

        $response = $this->getJson(
            route('api.services.orders.index', $service)
        );

        $response->assertOk()->assertSee($order->date);
    }

    /**
     * @test
     */
    public function it_can_attach_orders_to_service(): void
    {
        $service = Service::factory()->create();
        $order = Order::factory()->create();

        $response = $this->postJson(
            route('api.services.orders.store', [$service, $order])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $service
                ->orders()
                ->where('orders.id', $order->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_orders_from_service(): void
    {
        $service = Service::factory()->create();
        $order = Order::factory()->create();

        $response = $this->deleteJson(
            route('api.services.orders.store', [$service, $order])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $service
                ->orders()
                ->where('orders.id', $order->id)
                ->exists()
        );
    }
}
