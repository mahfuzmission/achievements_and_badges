<?php

namespace App\Service\Comment;

interface CommentListenerInterface
{
    public static function commentListener($comment);
}
