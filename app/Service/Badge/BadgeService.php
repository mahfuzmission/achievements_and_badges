<?php

namespace App\Service\Badge;

use App\Models\Badge;

class BadgeService
{

    public static function getBadgeBySlug($badge_slug)
    {
        return Badge::where('badge_slug', $badge_slug )->first();
    }


    public static function getBadgeByID($badge_id)
    {
        return Badge::find($badge_id);
    }


    public static function getBadgeByPoint($total_achievement)
    {
        return Badge::where('achievement_required', '<=', $total_achievement)
            ->orderBy('id','desc')
            ->first();
    }


}
