<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PublishPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Command executed');

        $postIds = Post::where('status', 'scheduled')
            ->where('scheduled_time', '<=', now())
            ->pluck('id')
            ->toArray();


        DB::table('platform_posts')
            ->whereIn('post_id', $postIds)
            ->update(['platform_status' => 'published']);

        DB::table('posts')
            ->whereIn('id', $postIds)
            ->update(['status' => 'published']);
            
        $this->info('Posts published');
    }
}
