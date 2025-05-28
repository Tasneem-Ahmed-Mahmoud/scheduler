<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    /**
     * Get the list of all available platforms
     */
    public function index()
    {
        $platforms = Platform::all();

        return ApiResponseSuccess("Platforms successfully fetched.", [
            'platforms' => PlatformResource::collection($platforms)
        ]);
    }

    /**
     * Toggle a platform as active/inactive for current user
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'platform_id' => ['required', 'exists:platforms,id'],
        ]);

        $user = Auth::user();
        $platformId = $request->platform_id;

        $status = $user->togglePlatform($platformId);

        return ApiResponseSuccess("Platform successfully {$status}.", [
            'platform_id' => $platformId,
            'status' => $status
        ]);
    }
}
