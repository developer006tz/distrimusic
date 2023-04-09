<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SocialMediaPlatform;
use Illuminate\Database\Eloquent\Factories\Factory;

class SocialMediaPlatformFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialMediaPlatform::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(255),
            'status' => '1',
        ];
    }
}
