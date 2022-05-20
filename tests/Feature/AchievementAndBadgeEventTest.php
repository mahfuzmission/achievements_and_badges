<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AchievementAndBadgeEventTest extends TestCase
{

    public static $user;
    public static $lessons;

    public function setUp() : void
    {
        parent::setUp();

//        $this->runDatabaseMigrations();

        if (is_null(self::$user)) {
            self::$user = User::factory()->create();
        }

        if(empty(self::$lessons))
        {
            self::$lessons = Lesson::factory()->count(50)->create();
        }
    }

    public function test_noAchievementEarnedByUser()
    {
        $user = self::$user;

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                ],
                "next_available_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Beginner",
                "next_badge" => "Intermediate",
                "remaing_to_unlock_next_badge" => 4
            ]
        );
    }

    public function test_firstAchievementByLesson()
    {
        $user = self::$user;
        $lesson = self::$lessons[0];

        DB::table('lesson_user')->insert([
            'watched' => 1,
            'lesson_id' => $lesson->id,
            'user_id' => $user->id,
        ]);

        event(new LessonWatched($lesson, $user));

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                        "First Lesson Watched"
                    ],
                "next_available_achievements" => [
                        "5 Lessons Watched",
                        "10 Lessons Watched",
                        "25 Lessons Watched",
                        "50 Lessons Watched",
                        "First Comment Written",
                        "3 Comments Written",
                        "5 Comments Written",
                        "10 Comments Written",
                        "20 Comments Written"
                    ],
                "current_badge" => "Beginner",
                "next_badge" => "Intermediate",
                "remaing_to_unlock_next_badge" => 3
            ]
        );
    }

    public function test_secondAchievementByLesson()
    {
        $user = self::$user;
        for($i = 1; $i < 5; $i++)
        {
            DB::table('lesson_user')->insert([
                'watched' => 1,
                'lesson_id' => self::$lessons[$i]->id,
                'user_id' => $user->id,
            ]);

            event(new \App\Events\LessonWatched( self::$lessons[$i], $user));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched"
                ],
                "next_available_achievements" => [
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Beginner",
                "next_badge" => "Intermediate",
                "remaing_to_unlock_next_badge" => 2
            ]
        );
    }

    public function test_thirdAchievementByLesson()
    {
        $user = self::$user;
        for($i = 5; $i < 10; $i++)
        {
            DB::table('lesson_user')->insert([
                'watched' => 1,
                'lesson_id' => self::$lessons[$i]->id,
                'user_id' => $user->id,
            ]);

            event(new \App\Events\LessonWatched( self::$lessons[$i], $user));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched"
                ],
                "next_available_achievements" => [
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Beginner",
                "next_badge" => "Intermediate",
                "remaing_to_unlock_next_badge" => 1
            ]
        );
    }

    public function test_fourthAchievementByLesson()
    {
        $user = self::$user;
        for($i = 10; $i < 25; $i++)
        {
            DB::table('lesson_user')->insert([
                'watched' => 1,
                'lesson_id' => self::$lessons[$i]->id,
                'user_id' => $user->id,
            ]);

            event(new \App\Events\LessonWatched( self::$lessons[$i], $user));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched"
                ],
                "next_available_achievements" => [
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Intermediate",
                "next_badge" => "Advanced",
                "remaing_to_unlock_next_badge" => 4
            ]
        );
    }

    public function test_fifthAchievementByLesson()
    {
        $user = self::$user;
        for($i = 15; $i < 50; $i++)
        {
            DB::table('lesson_user')->insert([
                'watched' => 1,
                'lesson_id' => self::$lessons[$i]->id,
                'user_id' => $user->id,
            ]);

            event(new \App\Events\LessonWatched( self::$lessons[$i], $user));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched"
                ],
                "next_available_achievements" => [
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Intermediate",
                "next_badge" => "Advanced",
                "remaing_to_unlock_next_badge" => 3
            ]
        );
    }

    public function test_firstAchievementByComment()
    {
        $user = self::$user;
        $comment = Comment::create([
            'body' => "This is my 1 comment",
            'user_id' => $user->id
        ]);

        event(new CommentWritten($comment));

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written"
                ],
                "next_available_achievements" => [
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Intermediate",
                "next_badge" => "Advanced",
                "remaing_to_unlock_next_badge" => 2
            ]
        );
    }

    public function test_secondAchievementByComment()
    {
        $user = self::$user;
        for($i = 2; $i <= 3; $i++) {
            $comment = Comment::create([
                'body' => "This is my $i comment",
                'user_id' => $user->id
            ]);

            event(new CommentWritten($comment));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written"
                ],
                "next_available_achievements" => [
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Intermediate",
                "next_badge" => "Advanced",
                "remaing_to_unlock_next_badge" => 1
            ]
        );
    }

    public function test_thirdAchievementByComment()
    {
        $user = self::$user;
        for($i = 4; $i <= 5; $i++) {
            $comment = Comment::create([
                'body' => "This is my $i comment",
                'user_id' => $user->id
            ]);

            event(new CommentWritten($comment));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written"
                ],
                "next_available_achievements" => [
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "current_badge" => "Advanced",
                "next_badge" => "Master",
                "remaing_to_unlock_next_badge" => 2
            ]
        );
    }

    public function test_fourthAchievementByComment()
    {
        $user = self::$user;
        for($i = 6; $i <= 10; $i++) {
            $comment = Comment::create([
                'body' => "This is my $i comment",
                'user_id' => $user->id
            ]);

            event(new CommentWritten($comment));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written"
                ],
                "next_available_achievements" => [
                    "20 Comments Written"
                ],
                "current_badge" => "Advanced",
                "next_badge" => "Master",
                "remaing_to_unlock_next_badge" => 1
            ]
        );
    }

    public function test_fifthAchievementByComment()
    {
        $user = self::$user;
        for($i = 11; $i <= 20; $i++) {
            $comment = Comment::create([
                'body' => "This is my $i comment",
                'user_id' => $user->id
            ]);

            event(new CommentWritten($comment));
        }

        $response = $this->get("/users/$user->id/achievements");
        $response->assertExactJson(
            [
                "unlocked_achievements" => [
                    "First Lesson Watched",
                    "5 Lessons Watched",
                    "10 Lessons Watched",
                    "25 Lessons Watched",
                    "50 Lessons Watched",
                    "First Comment Written",
                    "3 Comments Written",
                    "5 Comments Written",
                    "10 Comments Written",
                    "20 Comments Written"
                ],
                "next_available_achievements" => [
                ],
                "current_badge" => "Master",
                "next_badge" => "",
                "remaing_to_unlock_next_badge" => 0
            ]
        );
    }
}
