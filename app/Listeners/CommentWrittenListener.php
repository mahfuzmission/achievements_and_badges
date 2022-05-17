<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserAchievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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

        $user = $this->getUser($event->comment->user_id);

        if(! empty($user))
        {
            Log::info("Comment Written Listener - user id : ".$user->id);

            $total_comment_count = $this->getTotalCommentCount($user->id);
            $next_achievement = $this->getAchievement($total_comment_count, 'comment');

            if(! empty($next_achievement)  )
            {
                Log::info("Comment Written Listener - new achievement found");
                event(new AchievementUnlocked($next_achievement->slug, $user));
            }
        }

        Log::info("Comment Written Listener ended");
    }

    private function getUser($user_id)
    {
        return User::find($user_id) ;
    }

    private function getTotalCommentCount($user_id)
    {
        return Comment::where('user_id',$user_id)
            ->count();
    }

    private function currentAchievement($user_id)
    {
        return UserAchievement::where('user_id', $user_id)
            ->first();
    }

    private function getAchievement($task_need_to_complete, $type)
    {
        return Achievement::where('type', $type)
            ->where('need_to_complete', '==', $task_need_to_complete)
            ->first();
    }
}
