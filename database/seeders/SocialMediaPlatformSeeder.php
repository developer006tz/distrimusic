<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialMediaPlatform;

class SocialMediaPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialMediaPlatform::factory()
            ->count(5)
            ->create();
    }
}
