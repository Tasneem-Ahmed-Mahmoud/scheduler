<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Services\HelperService;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_time', $request->date);
        }

        $posts = $query->with('platforms')->latest()->paginate(10);

        return response()->json($posts);
    }

    public function store(StorePostRequest $request)
    {
        $storedImage = HelperService::StoreImage($request->file('image'));

        if (!$storedImage) {
            return response()->json(['message' => 'Image upload failed.'], 422);
        }

        $post = Post::create([
            'title'          => $request->title,
            'content'        => $request->content,
            'image_url'      =>  $storedImage,
            'scheduled_time' => $request->scheduled_time,
            'status'         => $request->status,
            'user_id'        => Auth::id(),
        ]);

        $post->platforms()->attach($request->platform_ids, ['platform_status' => 'pending']);

        return response()->json(['message' => 'Post created successfully.', 'post' => PostResource::make($post)], 201);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($post->status !== 'scheduled') {
            return response()->json(['message' => 'Only scheduled posts can be updated.'], 400);
        }

        $post->update($request->only(['title', 'content', 'scheduled_time', 'status']));

        if ($request->hasFile('image')) {

            $storedImage = HelperService::StoreImage($request->file('image'));

            if (!$storedImage) {
                return response()->json(['message' => 'Image upload failed.'], 422);
            }

            $post->image_url = $storedImage;
            $post->save();
        }


        $post->platforms()->sync($request->platform_ids, ['platform_status' => 'pending']);


        return response()->json(['message' => 'Post updated successfully.', 'post' => PostResource::make($post->load('platforms'))]);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();
        
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}
