<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SocialMediaPlatform;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SocialMediaPlatformControllerTest extends TestCase
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
    public function it_displays_index_view_with_social_media_platforms(): void
    {
        $socialMediaPlatforms = SocialMediaPlatform::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('social-media-platforms.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.social_media_platforms.index')
            ->assertViewHas('socialMediaPlatforms');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_social_media_platform(): void
    {
        $response = $this->get(route('social-media-platforms.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.social_media_platforms.create');
    }

    /**
     * @test
     */
    public function it_stores_the_social_media_platform(): void
    {
        $data = SocialMediaPlatform::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('social-media-platforms.store'), $data);

        $this->assertDatabaseHas('social_media_platforms', $data);

        $socialMediaPlatform = SocialMediaPlatform::latest('id')->first();

        $response->assertRedirect(
            route('social-media-platforms.edit', $socialMediaPlatform)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_social_media_platform(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();

        $response = $this->get(
            route('social-media-platforms.show', $socialMediaPlatform)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.social_media_platforms.show')
            ->assertViewHas('socialMediaPlatform');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_social_media_platform(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();

        $response = $this->get(
            route('social-media-platforms.edit', $socialMediaPlatform)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.social_media_platforms.edit')
            ->assertViewHas('socialMediaPlatform');
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

        $response = $this->put(
            route('social-media-platforms.update', $socialMediaPlatform),
            $data
        );

        $data['id'] = $socialMediaPlatform->id;

        $this->assertDatabaseHas('social_media_platforms', $data);

        $response->assertRedirect(
            route('social-media-platforms.edit', $socialMediaPlatform)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_social_media_platform(): void
    {
        $socialMediaPlatform = SocialMediaPlatform::factory()->create();

        $response = $this->delete(
            route('social-media-platforms.destroy', $socialMediaPlatform)
        );

        $response->assertRedirect(route('social-media-platforms.index'));

        $this->assertModelMissing($socialMediaPlatform);
    }
}
