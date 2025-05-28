<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function index()
    {

        $userPlatforms = auth()->user()->platforms()->select('platform_id')->get()->pluck('platform_id')->toArray();
        $allPlatforms = Platform::select('id', 'name')->get();

        return view('user.platforms.index', compact('userPlatforms', 'allPlatforms'));
    }

    public function sync(Request $request)
    {
        $user = auth()->user();
        $platformIds = $request->input('platforms', []);

        $user->platforms()->sync($platformIds);

        return redirect()->route('user.platforms')->with('success', 'Platforms updated successfully.');
    }
}
