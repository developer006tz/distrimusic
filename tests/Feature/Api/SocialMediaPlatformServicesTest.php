<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Service;
use App\Models\SocialMediaPlatform;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialMediaPlatformServicesTest extends TestCase
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
    public function it_gets_social_media_platform_services(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();
        $services = Service::factory()
            ->count(2)
            ->create([
                'social_media_platform_id' => $socialMediaPlatform->id,
            ]);

        $response = $this->getJson(
            route(
                'api.social-media-platforms.services.index',
                $socialMediaPlatform
            )
        );

        $response->assertOk()->assertSee($services[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_social_media_platform_services(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();
        $data = Service::factory()
            ->make([
                'social_media_platform_id' => $socialMediaPlatform->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.social-media-platforms.services.store',
                $socialMediaPlatform
            ),
            $data
        );

        unset($data['social_media_platform_id']);

        $this->assertDatabaseHas('services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $service = Service::latest('id')->first();

        $this->assertEquals(
            $socialMediaPlatform->id,
            $service->social_media_platform_id
        );
    }
}
