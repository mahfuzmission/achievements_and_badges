<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;


    protected $table = "achievements";
//    /**
//     * The comments that belong to the user.
//     */
//    public function requirements()
//    {
//        return $this->hasMany(UserAchievementHistory::class);
//    }
}
