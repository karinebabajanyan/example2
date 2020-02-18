<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->confirmed_at=date("Y-m-d h:i:s", time());
        $user->password=bcrypt($user->password);
    }

    public function created(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function updated(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        //
    }

    public function saved(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restoring(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }
}