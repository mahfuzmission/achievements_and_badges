<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Service\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CommentWrittenListener
{

    private $achievement_service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->achievement_service = new AchievementService();
    }

    /**
     * Handle the event.
     *
     * @param CommentWritten $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        Log::info("Comment Written Listener started ");

        $user = $this->achievement_service->getUser($event->comment->user_id);

        if(! empty($user))
        {
            Log::info("Comment Written Listener - user id : ".$user->id);

            $total_comment_count = $this->achievement_service->getTotalCommentCount($user->id);
            $next_achievement = $this->achievement_service->getAchievement($total_comment_count, 'comment');

            if(! empty($next_achievement)  )
            {
                Log::info("Comment Written Listener - new achievement found");
                event(new AchievementUnlocked($next_achievement->slug, $user));
            }
        }

        Log::info("Comment Written Listener ended");
    }


}
