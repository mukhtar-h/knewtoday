<?php

namespace App\Enums;

enum NewsletterStatus: string
{
    case Subscribed = 'subscribed';
    case Unsubscribed = 'unsubscribed';

    public static function options(): array
    {
        return [
            self::Subscribed->value,
            self::Unsubscribed->value,
        ];
    }
}
