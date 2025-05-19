<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class CreatedByEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(Model $data)
    {
        if (auth()->check()) {
            $data->created_by = auth()->user()->id;
        }
    }

}