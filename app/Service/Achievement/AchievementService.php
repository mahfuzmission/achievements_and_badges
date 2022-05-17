<?php

namespace App\Service\Achievement;

use App\Models\Achievement;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserAchievementHistory;

class AchievementService
{

    public static function getUser($user_id)
    {
        return User::find($user_id);
//        return User::with(['achievement'])->find($user_id) ;
    }


    public static function getTotalCommentCount($user_id)
    {
        return Comment::where('user_id',$user_id)
            ->count();
    }


    public static function getUserAchievement($user_id)
    {
        return UserAchievement::where('user_id', $user_id)
            ->first();
    }


    public static function getAchievement($task_need_to_complete, $type)
    {
        return Achievement::where('type', $type)
            ->where('need_to_complete', '=', $task_need_to_complete)
            ->first();
    }


    public static function updateUserAchievement($user_id, $data)
    {
        return UserAchievement::where('user_id',$user_id)->update($data);
    }


    public static function createUserAchievement($data)
    {
        return UserAchievement::create($data);
    }


    public static function createUserAchievementHistory($history)
    {
        UserAchievementHistory::create($history);
    }


    public static function getAchievementBySlug($slug)
    {
        return Achievement::where('slug', $slug)->first();
    }


}