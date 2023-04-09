<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vendor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_vendors(): void
    {
        $vendors = Vendor::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vendors.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.index')
            ->assertViewHas('vendors');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vendor(): void
    {
        $response = $this->get(route('vendors.create'));

        $response->assertOk()->assertViewIs('app.vendors.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vendor(): void
    {
        $data = Vendor::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vendors.store'), $data);

        $this->assertDatabaseHas('vendors', $data);

        $vendor = Vendor::latest('id')->first();

        $response->assertRedirect(route('vendors.edit', $vendor));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->get(route('vendors.show', $vendor));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.show')
            ->assertViewHas('vendor');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->get(route('vendors.edit', $vendor));

        $response
            ->assertOk()
            ->assertViewIs('app.vendors.edit')
            ->assertViewHas('vendor');
    }

    /**
     * @test
     */
    public function it_updates_the_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'status' => '1',
        ];

        $response = $this->put(route('vendors.update', $vendor), $data);

        $data['id'] = $vendor->id;

        $this->assertDatabaseHas('vendors', $data);

        $response->assertRedirect(route('vendors.edit', $vendor));
    }

    /**
     * @test
     */
    public function it_deletes_the_vendor(): void
    {
        $vendor = Vendor::factory()->create();

        $response = $this->delete(route('vendors.destroy', $vendor));

        $response->assertRedirect(route('vendors.index'));

        $this->assertModelMissing($vendor);
    }
}
