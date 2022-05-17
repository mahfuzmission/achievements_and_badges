<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\UserAchievement;
use App\Models\UserAchievementHistory;
use App\Service\Achievement\AchievementService;
use App\Service\Badge\BadgeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param AchievementUnlocked $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        Log::info("Achievement Unlocked Listener started.");

        $achievement = AchievementService::getAchievementBySlug($event->achievement_name);

        if(! empty($achievement))
        {
            Log::info("Achievement Unlocked Listener - achievement name : ".$achievement->name);
            $user_achievement = AchievementService::getUserAchievement($event->user->id);
            $badge_id = $user_achievement->badge_id ?? 1;
            $total_achievement = 0;

            if(empty($user_achievement))
            {
                Log::info("Achievement Unlocked Listener - achievement user created user_id : ".$event->user->id);
                $total_achievement = $achievement->earn_achievement;
                AchievementService::createUserAchievement(
                    [
                        'user_id' => $event->user->id,
                        'badge_id' => $badge_id,
                        'total_earned_achievement' => $total_achievement
                    ]
                );
            }
            else
            {
                Log::info("Achievement Unlocked Listener - achievement user updated user_id : ".$event->user->id);
                $total_achievement = $user_achievement->total_earned_achievement + $achievement->earn_achievement;
                AchievementService::updateUserAchievement($event->user->id,
                    [
                        'total_earned_achievement' => $total_achievement
                    ]
                );
            }

            AchievementService::createUserAchievementHistory(
                [
                    'user_id' => $event->user->id,
                    'achievement_type' => $achievement->type,
                    'achievement_name' => $achievement->name,
                    'achievement_slug' => $achievement->slug,
                    'earn_achievement' => $achievement->earn_achievement
                ]
            );

            $next_badge = BadgeService::getBadge($badge_id + 1, $total_achievement);

            if(!empty($next_badge))
            {
                event(new BadgeUnlocked($next_badge->badge_slug, $event->user));
            }

        }

        Log::info("Achievement Unlocked Listener ended");
    }

}
