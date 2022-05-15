<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('badge_name',50);
            $table->string('badge_slug',50)->index();
            $table->unsignedInteger('achievement_required');
            $table->timestamps();
        });


        DB::table('badges')->insert(
            [
                [
                    'badge_name' => 'Beginner',
                    'badge_slug' => 'beginner',
                    'achievement_required' => 0
                ],
                [
                    'badge_name' => 'Intermediate',
                    'badge_slug' => 'intermediate',
                    'achievement_required' => 4
                ],
                [
                    'badge_name' => 'Advanced',
                    'badge_slug' => 'advanced',
                    'achievement_required' => 8
                ],
                [
                    'badge_name' => 'Master',
                    'badge_slug' => 'master',
                    'achievement_required' => 10
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
        Schema::dropIfExists('badges');
    }
}
