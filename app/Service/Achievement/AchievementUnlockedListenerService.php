<?php

namespace App\Service\Achievement;

use App\Events\BadgeUnlocked;
use App\Service\Badge\BadgeService;
use Illuminate\Support\Facades\Log;

class AchievementUnlockedListenerService implements AchievementUnlockedListenerInterface
{
    public static function achievementUnlockedListener($achievement_name, $user)
    {
        $achievement = AchievementService::getAchievementBySlug($achievement_name);

        if(! empty($achievement))
        {
            Log::info("Achievement Unlocked Listener - achievement name : ".$achievement->name);
            $user_achievement = AchievementService::getUserAchievement($user->id);
            $badge_id = $user_achievement->badge_id ?? 1;
            $total_achievement = 0;

            if(empty($user_achievement))
            {
                Log::info("Achievement Unlocked Listener - achievement user created user_id : ".$user->id);
                $total_achievement = $achievement->earn_achievement;
                AchievementService::createUserAchievement(
                    [
                        'user_id' => $user->id,
                        'badge_id' => $badge_id,
                        'total_earned_achievement' => $total_achievement
                    ]
                );
            }
            else
            {
                Log::info("Achievement Unlocked Listener - achievement user updated user_id : ".$user->id);
                $total_achievement = $user_achievement->total_earned_achievement + $achievement->earn_achievement;
                AchievementService::updateUserAchievement($user->id,
                    [
                        'total_earned_achievement' => $total_achievement
                    ]
                );
            }

            AchievementService::createUserAchievementHistory(
                [
                    'user_id' => $user->id,
                    'achievement_type' => $achievement->type,
                    'achievement_name' => $achievement->name,
                    'achievement_slug' => $achievement->slug,
                    'earn_achievement' => $achievement->earn_achievement
                ]
            );

            $next_badge = BadgeService::getBadgeByPoint($total_achievement);

            if(!empty($next_badge) && $next_badge->id > $badge_id)
            {
                Log::info("Achievement Unlocked Listener - new badge unlocked");
                event(new BadgeUnlocked($next_badge->badge_slug, $user));
            }
        }
    }
}
