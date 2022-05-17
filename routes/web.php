<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);


Route::get('/', function (){

    $user = \App\Models\User::factory()->create();

    $data = [];

    $comment = \App\Models\Comment::create([
        'body' => "This is my first comment",
        'user_id'=> $user->id
//        'user_id'=> 1
    ]);

    event( new \App\Events\CommentWritten($comment));

    $data['comment'] = $comment;

    return response()->json(["data" => $data]);
});
