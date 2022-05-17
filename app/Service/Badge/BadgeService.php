<?php

namespace App\Service\Badge;

use App\Models\Badge;

class BadgeService
{

    public function getBadgeBySlug($badge_slug)
    {
        return Badge::where('badge_slug', $badge_slug )->first();
    }


    public function getBadge($badge_id, $total_achievement=null)
    {
        return Badge::where('id',$badge_id)
            ->when( ($total_achievement == null), function ($query, $total_achievement) {
                return $query->where('achievement_required', '<=', $total_achievement);
            })
            ->first();
    }


}
