<?php

namespace App\Service\Lesson;

interface LessonListenerInterface
{
    public static function lessonListener($lesson, $user);
}
