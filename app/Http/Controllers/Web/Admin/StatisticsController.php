<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $monthlyPosts = Post::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', 2025)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');


        $postsData = [];

        for ($i = 1; $i <= 12; $i++) {
            $postsData[] = $monthlyPosts[$i] ?? 0;
        }
       
        $statistics = [
            'total_posts' => Post::count(),
            'total_users' => User::query()->where('is_admin', false)->count(),
            'platforms' => Platform::count(),
            'posts_per_platform' => Platform::withCount('posts')
                ->get()
                ->mapWithKeys(function ($platform) {
                    return [$platform->name => $platform->posts_count];
                }),
            'monthlyPostsData' => $postsData,

        ];
        
        return view('admin.statistics', with($statistics));
    }
}
