<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\UserAchievement;
use App\Models\UserAchievementHistory;
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
        $total_achievement = 0;
        Log::info("Achievement Unlocked Listener started.");

        $achievement = $this->getAchievementBySlug($event->achievement_name);//index the slug

        if(! empty($achievement))
        {
            Log::info("Achievement Unlocked Listener - achievement name : ".$achievement->name);
            $user_achievement = $this->getUserAchievement($event->user->id);
            $badge_id = $user_achievement->badge_id ?? 1;

            if(empty($user_achievement))
            {
                Log::info("Achievement Unlocked Listener - achievement user created user_id : ".$event->user->id);
                $total_achievement = $achievement->earn_achievement;
                $this->createUserAchievement(
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
                $this->updateUserAchievement($event->user->id,
                    [
                        'total_earned_achievement' => $total_achievement
                    ]
                );
            }

            $this->createUserAchievementHistory(
                [
                    'user_id' => $event->user->id,
                    'achievement_type' => $achievement->type,
                    'achievement_name' => $achievement->name,
                    'achievement_slug' => $achievement->slug,
                    'earn_achievement' => $achievement->earn_achievement
                ]
            );


            $next_badge = Badge::where('achievement_required', $total_achievement)
                ->where('id',$badge_id)
                ->first();

            if(!empty($next_badge))
            {
                event(new BadgeUnlocked());
            }

        }


        Log::info("Achievement Unlocked Listener ended");
    }


    public function getUserAchievement($user_id)
    {
        return UserAchievement::where('user_id', $user_id)
            ->first();
    }


    private function createUserAchievement($data)
    {
        return UserAchievement::create($data);
    }


    private function updateUserAchievement($user_id, $data)
    {
        return UserAchievement::where('user_id',$user_id)->update($data);
    }


    private function createUserAchievementHistory($history)
    {
        UserAchievementHistory::create($history);
    }


    private function getAchievementBySlug($slug)
    {
        return Achievement::where('slug', $slug)->first();
    }
}
