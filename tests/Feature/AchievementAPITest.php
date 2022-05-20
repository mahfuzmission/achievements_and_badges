<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AchievementAPITest extends TestCase
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
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_userAchievementUserNotFound()
    {
        $response = $this->get("/users/0/achievements");

        $response->assertStatus(404);
    }


    public function test_userAchievementUserFound()
    {
        $user = self::$user;

        $response = $this->get("/users/$user->id/achievements");

        $response->assertStatus(200);
    }
}
