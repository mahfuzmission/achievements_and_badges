<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Service\Lesson\LessonListenerService;
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

        LessonListenerService::lessonListener($event->lesson, $event->user);

        Log::info("Lesson Watched Listener ended");
    }
}
