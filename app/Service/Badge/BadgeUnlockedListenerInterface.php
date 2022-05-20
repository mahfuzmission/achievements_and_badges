<?php

namespace App\Service\Badge;

interface BadgeUnlockedListenerInterface
{
    public static function badgeUnlockedListener($badge_slug, $user);
}
