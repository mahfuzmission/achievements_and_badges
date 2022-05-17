<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\UserAchievement;
use App\Service\Achievement\AchievementService;
use App\Service\Badge\BadgeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        $badge = BadgeService::getBadgeBySlug($event->badge_slug);

        AchievementService::updateUserAchievement($event->user->id,
            [
                'badge_id' => $badge->id
            ]
        );
    }




}
