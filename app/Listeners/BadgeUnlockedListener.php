<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Service\Achievement\AchievementService;
use App\Service\Badge\BadgeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class BadgeUnlockedListener
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
     * @param BadgeUnlocked $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        Log::info("Badge Unlocked Listener ended");

        $badge = BadgeService::getBadgeBySlug($event->badge_slug);

        if(! empty($badge))
        {
            Log::info("Badge Unlocked Listener - badge updated : user_id".$event->user->id." badge_id : ".$badge->id);

            AchievementService::updateUserAchievement($event->user->id,
                [
                    'badge_id' => $badge->id
                ]
            );
        }

        Log::info("Badge Unlocked Listener ended");
    }




}
