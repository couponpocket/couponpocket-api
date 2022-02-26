<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class UserObserver
{
    public function created(User $user)
    {
        Event::dispatch(new Registered($user));
    }
}
