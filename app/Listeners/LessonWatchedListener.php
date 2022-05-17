<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Service\Achievement\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LessonWatchedListener
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
     * @param LessonWatched $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        Log::info("Lesson Watched Listener started ");

        $total_lesson__count = $event->user->watched()->count();
        $next_achievement = AchievementService::getAchievement($total_lesson__count, 'lesson');

        if(! empty($next_achievement)  )
        {
            Log::info("Lesson Watched Listener - new achievement found");
            event(new AchievementUnlocked($next_achievement->slug, $event->user));
        }

        Log::info("Lesson Watched Listener ended");
    }
}
