<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $badge_slug;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($badge_slug, User $user)
    {
        $this->badge_slug = $badge_slug;
        $this->user = $user;
    }
}
