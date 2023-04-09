<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Transaction;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorTransactionsTest extends TestCase
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
    public function it_gets_vendor_transactions(): void
    {
        $vendor = Vendor::factory()->create();
        $transaction = Transaction::factory()->create();

        $vendor->transactions()->attach($transaction);

        $response = $this->getJson(
            route('api.vendors.transactions.index', $vendor)
        );

        $response->assertOk()->assertSee($transaction->date);
    }

    /**
     * @test
     */
    public function it_can_attach_transactions_to_vendor(): void
    {
        $vendor = Vendor::factory()->create();
        $transaction = Transaction::factory()->create();

        $response = $this->postJson(
            route('api.vendors.transactions.store', [$vendor, $transaction])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $vendor
                ->transactions()
                ->where('transactions.id', $transaction->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_transactions_from_vendor(): void
    {
        $vendor = Vendor::factory()->create();
        $transaction = Transaction::factory()->create();

        $response = $this->deleteJson(
            route('api.vendors.transactions.store', [$vendor, $transaction])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $vendor
                ->transactions()
                ->where('transactions.id', $transaction->id)
                ->exists()
        );
    }
}
