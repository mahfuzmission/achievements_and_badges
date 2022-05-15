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
            $table->string('achievements_name',100);
            $table->string('achievements_slug',100);
            $table->timestamps();
        });

        DB::table('achievements')->insert(
            [
                [
                    'achievements_name' => 'Lessons Watched Achievement',
                    'achievements_slug' => 'lesson'
                ],
                [
                    'achievements_name' => 'Comments Written Achievement',
                    'achievements_slug' => 'comment'
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
