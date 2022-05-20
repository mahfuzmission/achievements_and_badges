<?php

namespace App\Service\Badge;

use App\Service\Achievement\AchievementService;
use Illuminate\Support\Facades\Log;

class BadgeListenerService implements BadgeUnlockedListenerInterface
{
    public static function badgeUnlockedListener($badge_slug, $user)
    {
        $badge = BadgeService::getBadgeBySlug($badge_slug);

        if(! empty($badge))
        {
            Log::info("Badge Unlocked Listener - badge updated : user_id".$user->id." badge_id : ".$badge->id);

            AchievementService::updateUserAchievement($user->id,
                [
                    'badge_id' => $badge->id
                ]
            );
        }
    }
}
