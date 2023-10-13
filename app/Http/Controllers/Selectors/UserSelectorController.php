<?php

namespace App\Http\Controllers\Selectors;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserSelectorResource;
use App\Models\User;
use Cache;
use Illuminate\Http\Request;

class UserSelectorController extends Controller
{
    private const CACHE_SECONDS = 600;

    public function __invoke(Request $request)
    {
        $type = $request->get('type');
        if (Cache::has("users-selector-$type")) {
            $users = Cache::get("users-selector-$type");
        } else {
            $users = User::select(['id', 'name'])->byType($type)->get();
            Cache::put("users-selector-$type", $users, now()->addSeconds(self::CACHE_SECONDS));
        }

        return UserSelectorResource::collection($users);
    }
}
