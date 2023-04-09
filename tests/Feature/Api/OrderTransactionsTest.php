<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTransactionsTest extends TestCase
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
    public function it_gets_order_transactions(): void
    {
        $order = Order::factory()->create();
        $transactions = Transaction::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(
            route('api.orders.transactions.index', $order)
        );

        $response->assertOk()->assertSee($transactions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_order_transactions(): void
    {
        $order = Order::factory()->create();
        $data = Transaction::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.transactions.store', $order),
            $data
        );

        $this->assertDatabaseHas('transactions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transaction = Transaction::latest('id')->first();

        $this->assertEquals($order->id, $transaction->order_id);
    }
}
