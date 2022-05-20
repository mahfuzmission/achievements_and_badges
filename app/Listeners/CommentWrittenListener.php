<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Service\Comment\CommentListenerService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CommentWrittenListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CommentWritten $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        Log::info("Comment Written Listener started ");

        CommentListenerService::commentListener($event->comment);

        Log::info("Comment Written Listener ended");
    }

}
