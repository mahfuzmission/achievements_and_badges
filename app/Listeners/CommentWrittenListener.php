<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Service\Achievement\AchievementService;
use Illuminate\Support\Facades\Log;

class CommentWrittenListener
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
     * @param CommentWritten $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        Log::info("Comment Written Listener started ");

        $user = AchievementService::getUser($event->comment->user_id);

        if(! empty($user))
        {
            Log::info("Comment Written Listener - user id : ".$user->id);

            $total_comment_count = AchievementService::getTotalCommentCount($user->id);
            $next_achievement = AchievementService::getAchievement($total_comment_count, 'comment');

            if(! empty($next_achievement)  )
            {
                Log::info("Comment Written Listener - new achievement found");
                event(new AchievementUnlocked($next_achievement->slug, $user));
            }
        }

        Log::info("Comment Written Listener ended");
    }
}
