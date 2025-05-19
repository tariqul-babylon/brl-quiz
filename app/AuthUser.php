<?php

namespace App;

trait AuthUser
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
