<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft          = 'draft';
    case UnderReview    = 'under_review';
    case Scheduled      = 'scheduled';
    case Published      = 'published';
    case Archived       = 'archived';

    public static function options()
    {
        return [
            self::Draft->value,
            self::UnderReview->value,
            self::Scheduled->value,
            self::Published->value,
            self::Archived->value,
        ];
    }
}
