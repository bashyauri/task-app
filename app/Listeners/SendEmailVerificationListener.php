<?php

namespace App\Listeners;

use App\Events\NewUserCreatedEvent;
use App\Mail\SendRegistrationMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserCreatedEvent $event): void
    {
        sleep(seconds: 5);
        Mail::to(users: $event->user->email)->send(mailable: new SendRegistrationMail(user: $event->user));
    }
}