<?php
namespace App\Http\Controllers\Api;

use App\Models\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Platform\PlatformResource;

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
