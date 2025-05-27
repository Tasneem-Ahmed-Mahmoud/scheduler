<?php

namespace Database\Seeders;

use App\Models\Platform;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $platforms = Platform::all();

        $post = Post::create([
            'title' => 'First Scheduled Post',
            'content' => 'This is a scheduled post for multiple platforms.',
            'scheduled_time' => now()->addDay(),
            'status' => 'scheduled',
            'user_id' => $user->id,
        ]);

        foreach ($platforms as $platform) {
            $post->platforms()->attach($platform->id, ['platform_status' => 'pending']);
        }
    }
}
