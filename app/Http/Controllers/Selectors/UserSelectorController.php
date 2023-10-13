<?php

namespace App\Http\Controllers\Selectors;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserSelectorResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserSelectorController extends Controller
{
    public function __invoke(Request $request)
    {
        $type = $request->get('type', 1);
        $users = User::select(['id', 'name'])->byType($type)->get();

        return UserSelectorResource::collection($users);
    }
}
