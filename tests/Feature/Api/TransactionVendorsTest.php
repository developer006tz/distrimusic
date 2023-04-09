<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionVendorsTest extends TestCase
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
    public function it_gets_transaction_vendors(): void
    {
        $transaction = Transaction::factory()->create();
        $vendor = Vendor::factory()->create();

        $transaction->vendors()->attach($vendor);

        $response = $this->getJson(
            route('api.transactions.vendors.index', $transaction)
        );

        $response->assertOk()->assertSee($vendor->name);
    }

    /**
     * @test
     */
    public function it_can_attach_vendors_to_transaction(): void
    {
        $transaction = Transaction::factory()->create();
        $vendor = Vendor::factory()->create();

        $response = $this->postJson(
            route('api.transactions.vendors.store', [$transaction, $vendor])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $transaction
                ->vendors()
                ->where('vendors.id', $vendor->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_vendors_from_transaction(): void
    {
        $transaction = Transaction::factory()->create();
        $vendor = Vendor::factory()->create();

        $response = $this->deleteJson(
            route('api.transactions.vendors.store', [$transaction, $vendor])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $transaction
                ->vendors()
                ->where('vendors.id', $vendor->id)
                ->exists()
        );
    }
}
