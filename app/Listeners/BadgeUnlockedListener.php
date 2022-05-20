<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Service\Badge\BadgeListenerService;
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

        BadgeListenerService::badgeUnlockedListener($event->badge_slug, $event->user);

        Log::info("Badge Unlocked Listener ended");
    }




}
