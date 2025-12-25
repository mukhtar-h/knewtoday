<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Admin      = 'admin';
    case Editor     = 'editor';
    case Writer     = 'writer';
    case User       = 'user';

    public static function options()
    {
        return [
            self::SuperAdmin->value,
            self::Admin->value,
            self::Editor->value,
            self::Writer->value,
            self::User->value,

        ];
    }
}
