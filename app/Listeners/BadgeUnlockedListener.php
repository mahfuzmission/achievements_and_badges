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

    private $badge_service;
    private $achievement_service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->badge_service = new BadgeService();
        $this->achievement_service = new AchievementService();
    }

    /**
     * Handle the event.
     *
     * @param BadgeUnlocked $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        $badge = $this->badge_service->getBadgeBySlug($event->badge_slug);

        $this->achievement_service->updateUserAchievement($event->user->id,
            [
                'badge_id' => $badge->id
            ]
        );
    }




}
