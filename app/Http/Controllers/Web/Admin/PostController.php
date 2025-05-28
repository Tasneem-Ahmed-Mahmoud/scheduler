<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->filters($request->all())
            ->with(['user', 'platforms'])
            ->whereNotNull('scheduled_time');

        $posts = $query->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }
}
