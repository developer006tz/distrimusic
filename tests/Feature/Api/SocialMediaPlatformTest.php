<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SocialMediaPlatform;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialMediaPlatformTest extends TestCase
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
    public function it_gets_social_media_platforms_list(): void
    {
        $socialMediaPlatforms = SocialMediaPlatform::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.social-media-platforms.index'));

        $response->assertOk()->assertSee($socialMediaPlatforms[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_social_media_platform(): void
    {
        $data = SocialMediaPlatform::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.social-media-platforms.store'),
            $data
        );

        $this->assertDatabaseHas('social_media_platforms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_social_media_platform(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();

        $data = [
            'name' => $this->faker->text(255),
            'status' => '1',
        ];

        $response = $this->putJson(
            route('api.social-media-platforms.update', $socialMediaPlatform),
            $data
        );

        $data['id'] = $socialMediaPlatform->id;

        $this->assertDatabaseHas('social_media_platforms', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_social_media_platform(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();

        $response = $this->deleteJson(
            route('api.social-media-platforms.destroy', $socialMediaPlatform)
        );

        $this->assertModelMissing($socialMediaPlatform);

        $response->assertNoContent();
    }
}
