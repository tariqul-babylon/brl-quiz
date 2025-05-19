<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class UpdatedByEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(Model $data)
    {
        if (auth()->check()) {
            $data->updated_by = auth()->user()->id;
        }
    }
}