<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Services\HelperService;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query()->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('scheduled_time', [$request->from, $request->to]);
        }

        $posts = $query->latest()->paginate(10);
        return view('user.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $platforms = Auth::user()->platforms()->get();


        return view('user.posts.create', compact('platforms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $storedImage = $request->hasFile('image')
            ? HelperService::StoreImage($request->file('image'))
            : null;

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image_url' => $storedImage,
            'scheduled_time' => $request->scheduled_time,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        $post->platforms()->attach($request->platform_ids, ['platform_status' => 'pending']);
        
        return redirect()->route('user.posts.index')->with('success', 'Post added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
