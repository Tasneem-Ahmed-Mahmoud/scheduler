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
        $platforms = Platform::latest()->get();
        return view('admin.platforms.index', compact('platforms'));
    }

    public function create()
    {
        return view('admin.platforms.create');
    }

    public function store(StorePlatformRequest $request)
    {
        Platform::create($request->validated());
        return redirect()->route('platforms.index')->with('success', 'Platform added.');
    }

    public function edit(Platform $platform)
    {
        return view('admin.platforms.edit', compact('platform'));
    }

    public function update(UpdatePlatformRequest $request, Platform $platform)
    {
        $platform->update($request->validated());
        return redirect()->route('platforms.index')->with('success', 'Platform updated.');
    }

    public function destroy(Platform $platform)
    {
        $platform->delete();
        return redirect()->route('platforms.index')->with('success', 'Platform deleted.');
    }
}
