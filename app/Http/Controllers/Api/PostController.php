<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Services\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

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
       
        return ApiResponseSuccess("Posts successfully fetched.", [
            'posts' => PostResource::collection($posts)
        ]);
    }



    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {
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

            DB::commit();

            return ApiResponseSuccess("Post created successfully.", [
                'post' => PostResource::make($post->load('platforms'))
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return ApiResponseError("Failed to create post.", $e->getMessage(), 500);
        }
    }


    public function update(UpdatePostRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {
            $data = $request->only(['title', 'content', 'scheduled_time', 'status']);

            if ($request->hasFile('image')) {
                $storedImage = HelperService::StoreImage($request->file('image'));

                if (!$storedImage) {
                    DB::rollBack();
                    return ApiResponseError("Image upload failed.", 422);
                }

                if ($post->image_url) {
                    HelperService::deleteImage($post->image_url);
                }

                $data['image_url'] = $storedImage;
            }

            $post->update($data);

            $post->platforms()->syncWithPivotValues($request->platform_ids, ['platform_status' => 'pending']);

            DB::commit();

            return ApiResponseSuccess("Post updated successfully.", [
                'post' => PostResource::make($post->load('platforms'))
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponseError("Something went wrong during update.", 500, [
                'error' => $e->getMessage()
            ]);
        }
    }


    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            return ApiResponseError("Unauthorized", 403);
        }

        DB::beginTransaction();

        try {

            if ($post->platforms()->exists()) {
                $post->platforms()->detach();
            }


            if ($post->image_url) {
                HelperService::deleteImage($post->image_url);
            }

            $post->delete();

            DB::commit();

            return ApiResponseSuccess("Post deleted successfully.");
        } catch (\Exception $e) {
            DB::rollBack();

            return ApiResponseError("Failed to delete post.", 500, [
                'error' => $e->getMessage(),
            ]);
        }
    }

}