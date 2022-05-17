<?php

namespace App\Service;

use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserAchievement;

class AchievementService
{
    public function getUser($user_id)
    {
        return User::find($user_id);
//        return User::with(['achievement'])->find($user_id) ;
    }

    public function getTotalCommentCount($user_id)
    {
        return Comment::where('user_id',$user_id)
            ->count();
    }

    public function getUserAchievement($user_id)
    {
        return UserAchievement::where('user_id', $user_id)
            ->first();
    }

    public function getAchievement($task_need_to_complete, $type)
    {
        return Achievement::where('type', $type)
            ->where('need_to_complete', '=', $task_need_to_complete)
            ->first();
    }
}
