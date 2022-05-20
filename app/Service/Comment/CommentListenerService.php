<?php

namespace App\Service\Comment;

use App\Events\AchievementUnlocked;
use App\Models\User;
use App\Service\Achievement\AchievementService;
use Illuminate\Support\Facades\Log;

class CommentListenerService implements CommentListenerInterface
{

    public static function commentListener($comment)
    {
        $user = self::getUser($comment->user_id);

        if(! empty($user))
        {
            Log::info("Comment Written Listener - user id : ".$user->id);

            $total_comment_count = $user->comments()->count();
            $next_achievement = AchievementService::getAchievement($total_comment_count, 'comment');

            if(! empty($next_achievement)  )
            {
                Log::info("Comment Written Listener - new achievement found");
                event(new AchievementUnlocked($next_achievement->slug, $user));
            }
        }
    }

    private static function getUser($user_id)
    {
        return User::find($user_id);
    }
}
