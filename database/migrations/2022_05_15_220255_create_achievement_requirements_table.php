<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAchievementRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('achievement_id');
            $table->string('requirement_name');
            $table->integer('need_to_complete');
            $table->integer('earn_achievement');
            $table->timestamps();

            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');
        });

        DB::table('achievement_requirements')->insert(
            [
                [
                    'achievement_id' => 1, // lesson achievement id
                    'requirement_name' => 'First Lesson Watched',
                    'need_to_complete' => 1,
                    'earn_achievement' => 1,
                ],
                [
                    'achievement_id' => 1, // lesson achievement id
                    'requirement_name' => '5 Lessons Watched',
                    'need_to_complete' => 5,
                    'earn_achievement' => 1,
                ],
                [
                    'achievement_id' => 1, // lesson achievement id
                    'requirement_name' => '10 Lessons Watched',
                    'need_to_complete' => 10,
                    'earn_achievement' => 1,
                ],
                [
                'achievement_id' => 1, // lesson achievement id
                'requirement_name' => '25 Lessons Watched',
                'need_to_complete' => 25,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 1, // lesson achievement id
                'requirement_name' => '50 Lessons Watched',
                'need_to_complete' => 50,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 2, // comment achievement id
                'requirement_name' => 'First Comment Written',
                'need_to_complete' => 1,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 2, // comment achievement id
                'requirement_name' => '3 Comments Written',
                'need_to_complete' => 3,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 2, // comment achievement id
                'requirement_name' => '5 Comments Written',
                'need_to_complete' => 5,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 2, // comment achievement id
                'requirement_name' => '10 Comment Written',
                'need_to_complete' => 10,
                'earn_achievement' => 1
                ],
                [
                'achievement_id' => 2, // comment achievement id
                'requirement_name' => '20 Comment Written',
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
        Schema::dropIfExists('achievement_requirements');
    }
}
