<?php

namespace App\Enums;

enum UserTypeEnum: int
{
    case ADMIN = 1;

    case USER = 2;

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::USER => 'user'
        };
    }

    public static function values(): array
    {
        $array = [];
        foreach (UserTypeEnum::cases() as $case) {
            $array[$case->value] = $case->label();
        }

        return $array;
    }
}
