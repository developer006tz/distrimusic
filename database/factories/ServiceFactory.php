<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'social_media_platform_id' => \App\Models\SocialMediaPlatform::factory(),
        ];
    }
}
