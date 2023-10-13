<?php

namespace App\Support;

use App\Enums\UserTypeEnum;
use App\Models\User;

class UserSupport
{
    public static function isAdmin(User $user): bool
    {
        return $user->type === UserTypeEnum::ADMIN->value;
    }
}
