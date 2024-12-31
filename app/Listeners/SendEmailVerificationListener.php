<?php

namespace App\Listeners;

use App\Events\NewUserCreatedEvent;
use App\Mail\SendRegistrationMail;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationListener
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
        Mail::to($event->user->email)->send(new SendRegistrationMail($event->user));
    }
}