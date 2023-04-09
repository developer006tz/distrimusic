<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserOrdersTest extends TestCase
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
    public function it_gets_user_orders(): void
    {
        $user = User::factory()->create();
        $orders = Order::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.orders.index', $user));

        $response->assertOk()->assertSee($orders[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_orders(): void
    {
        $user = User::factory()->create();
        $data = Order::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.orders.store', $user),
            $data
        );

        $this->assertDatabaseHas('orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $order = Order::latest('id')->first();

        $this->assertEquals($user->id, $order->user_id);
    }
}
