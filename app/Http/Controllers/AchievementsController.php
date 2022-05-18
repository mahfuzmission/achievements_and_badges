<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\UserAchievementHistory;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlocked_achievements = UserAchievementHistory::where('user_id', $user->id)->pluck('achievement_name', 'achievement_slug')->toArray();
        $next_available_achievements = Achievement::whereNotIn('slug', array_keys($unlocked_achievements))->pluck('name');

        $current_badge_id = $user->achievement->badge_id ?? 1;
        $next_badge_id = $current_badge_id + 1;
        $current_achievement = $user->achievement->total_earned_achievement ?? 0;

        $badge = Badge::whereIn('id', [$current_badge_id, $next_badge_id])->select('badge_name','achievement_required')->get();

        return response()->json([
            'unlocked_achievements' => array_values($unlocked_achievements),
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $badge[0]->badge_name,
            'next_badge' => $badge[1]->badge_name ?? '',
            'remaing_to_unlock_next_badge' => isset($badge[1]) ? ( $badge[1]->achievement_required - $current_achievement ) : 0
        ]);
    }
}
