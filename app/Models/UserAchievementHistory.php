<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAchievementHistory extends Model
{
    use HasFactory;


    protected $table = "user_achievement_history";

    protected $fillable = [
        'user_id',
        'achievement_type',
        'achievement_name',
        'achievement_slug',
        'earn_achievement'
    ];
}
