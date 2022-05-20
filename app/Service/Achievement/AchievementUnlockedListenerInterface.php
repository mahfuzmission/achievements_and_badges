<?php

namespace App\Service\Achievement;

interface AchievementUnlockedListenerInterface
{
    public static function achievementUnlockedListener($achievement_name, $user);
}
