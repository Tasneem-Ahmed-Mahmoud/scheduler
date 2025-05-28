<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlatformRequest;
use App\Http\Requests\UpdatePlatformRequest;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{

    public function index()
    {
        $platforms = Platform::withCount('posts')->latest()->get();

        return view('admin.platforms.index', compact('platforms'));
    }

    public function create()
    {
        return view('admin.platforms.create');
    }

    public function store(StorePlatformRequest $request)
    {
        $inputs = $request->validated();
        $inputs['allow_post_without_image'] = $request->has('allow_post_without_image') ? true : false;
        $inputs['max_post_words_count'] = $request->input('max_post_words_count', null);
        Platform::create($inputs);
        return redirect()->route('admin.platforms.index')->with('success', 'Platform added.');
    }

    public function edit(Platform $platform)
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        $inputs = $request->validated();

        if (!isset($inputs['allow_post_without_image'])) {
            $inputs['allow_post_without_image'] = false;
        } else {
            $inputs['allow_post_without_image'] = true;
        }

        if (!isset($inputs['max_post_words_count'])) {
            $inputs['max_post_words_count'] = null;
        }

        $platform->update($inputs);

        return redirect()->route('admin.platforms.index')->with('success', 'Platform updated.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return redirect()->route('admin.platforms.index')->with('success', 'Platform deleted.');
    }
}
