<?php

namespace App\Listeners;

use BeyondCode\EmailConfirmation\Events\Confirmed;
use App\Mail\UserRedistredMailToUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToUser
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
     * @param  Confirmed  $event
     * @return void
     */
    public function handle(Confirmed $event)
    {
        //
        \Mail::to($event->user->email)->send(new UserRedistredMailToUser($event->user));
    }
}
