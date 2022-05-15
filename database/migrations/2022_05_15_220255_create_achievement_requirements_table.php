<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
