<?php

namespace Tests\Events;

use App\Models\User;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class RegisteredTest extends \Tests\TestCase
{
    public function testEmailSent()
    {
        Notification::fake();

        $user = new User();
        Event::dispatch(new Registered($user));

        Notification::assertTimesSent(1, VerifyEmail::class);
    }
}
