<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['lesson','comment']);
            $table->string('name');
            $table->string('slug')->index();
            $table->integer('need_to_complete');
            $table->integer('earn_achievement');
            $table->boolean('status')->default('1');
            $table->timestamps();

        });

        DB::table('achievements')->insert(
            [
                [
                    'type' => 'lesson',
                    'name' => 'First Lesson Watched',
                    'slug' => 'one_lesson',
                    'need_to_complete' => 1,
                    'earn_achievement' => 1,
                ],
                [
                    'type' => 'lesson',
                    'name' => '5 Lessons Watched',
                    'slug' => 'five_lesson',
                    'need_to_complete' => 5,
                    'earn_achievement' => 1,
                ],
                [
                    'type' => 'lesson',
                    'name' => '10 Lessons Watched',
                    'slug' => 'ten_lesson',
                    'need_to_complete' => 10,
                    'earn_achievement' => 1,
                ],
                [
                    'type' => 'lesson',
                    'name' => '25 Lessons Watched',
                    'slug' => 'twenty_five_lesson',
                    'need_to_complete' => 25,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'lesson',
                    'name' => '50 Lessons Watched',
                    'slug' => 'fifty_lesson',
                    'need_to_complete' => 50,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'comment',
                    'name' => 'First Comment Written',
                    'slug' => 'one_comment',
                    'need_to_complete' => 1,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'comment',
                    'name' => '3 Comments Written',
                    'slug' => 'three_comment',
                    'need_to_complete' => 3,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'comment',
                    'name' => '5 Comments Written',
                    'slug' => 'five_comment',
                    'need_to_complete' => 5,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'comment',
                    'name' => '10 Comments Written',
                    'slug' => 'ten_comment',
                    'need_to_complete' => 10,
                    'earn_achievement' => 1
                ],
                [
                    'type' => 'comment',
                    'name' => '20 Comments Written',
                    'slug' => 'twenty_comment',
                    'need_to_complete' => 20,
                    'earn_achievement' => 1
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
