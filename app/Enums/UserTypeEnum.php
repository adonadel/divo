<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case ADMIN = 'ADMIN';
    case USER = 'USER';

    public static function toArrayWithString(): array
    {
        return collect(self::cases())->map( function($case) {
            return $case->value;
        })->toArray();
    }
}
