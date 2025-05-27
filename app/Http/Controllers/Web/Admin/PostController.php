<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('scheduled_for', [$request->from, $request->to]);
        }

        $posts = $query->latest()->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

public function calendar()
{
    $posts = Post::whereNotNull('scheduled_time')->get();
    return view('admin.posts.calendar', compact('posts'));
}
    
}
