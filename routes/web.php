<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementsController;

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index']);

Route::get('/', function (){

//    $user = \App\Models\User::find(1);
//
//    if(empty($user))
//    {
//        $user = \App\Models\User::factory()->create();
//    }
//
//    $data['lesson'] = \App\Models\Lesson::factory()->count(50)->create();
//
//    foreach ($data['lesson'] as $lesson)
//    {
//        \Illuminate\Support\Facades\DB::table('lesson_user')->insert([
//            'watched' => 1,
//            'lesson_id' => $lesson->id,
//            'user_id' => $user->id,
//        ]);
//
//        event(new \App\Events\LessonWatched($lesson, $user));
//    }
//
//    for($i = 0; $i <= 1; $i++)
//    {
//        $comment = \App\Models\Comment::create([
//            'body' => "This is my $i comment",
//            'user_id'=> $user->id
//        ]);
//
//        event( new \App\Events\CommentWritten($comment));
//        $data['comment'][] = $comment;
//    }
//

    return response()->json(["data" => $data ?? "none"]);
});
