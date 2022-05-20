<?php

namespace App\Service\Lesson;

use App\Events\AchievementUnlocked;
use App\Service\Achievement\AchievementService;
use Illuminate\Support\Facades\Log;

class LessonListenerService implements LessonListenerInterface
{
    public static function lessonListener($lesson, $user)
    {
        $total_lesson_count = $user->watched()->count();
        $next_achievement = AchievementService::getAchievement($total_lesson_count, 'lesson');

        if(! empty($next_achievement)  )
        {
            Log::info("Lesson Watched Listener - new achievement found");
            event(new AchievementUnlocked($next_achievement->slug, $user));
        }
    }
}
