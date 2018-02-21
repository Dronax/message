<?php

namespace App\Listeners;

use App\Events\MessageIsSeen;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageIsSeenListener
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
     * @param  MessageIsSeen  $event
     * @return void
     */
    public function handle(MessageIsSeen $event)
    {
        //
    }
}
