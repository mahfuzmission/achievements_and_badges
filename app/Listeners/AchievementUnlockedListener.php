<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Service\Achievement\AchievementUnlockedListenerService;
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

        AchievementUnlockedListenerService::achievementUnlockedListener($event->achievement_name, $event->user);

        Log::info("Achievement Unlocked Listener ended");
    }

}
