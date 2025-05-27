<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['id' => 1, 'name' => 'Twitter', 'type' => 'twitter', 'max_post_words_count' => 50, 'allow_post_without_image' => false],
            ['id' => 2, 'name' => 'Instagram', 'type' => 'instagram', 'max_post_words_count' => null, 'allow_post_without_image' => true],
            ['id' => 3, 'name' => 'LinkedIn', 'type' => 'linkedin', 'max_post_words_count' => 50, 'allow_post_without_image' => false],
        ];

        Platform::insert($platforms);

        $user = User::where('is_admin', false)->first();
        $user->platforms()->attach([
            $platforms[0]['id'],
            $platforms[1]['id'],
            $platforms[2]['id'],
        ]);
    }
}
