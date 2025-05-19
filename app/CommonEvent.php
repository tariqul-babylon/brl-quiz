<?php

namespace App;

use App\Events\CreatedByEvent;
use App\Events\UpdatedByEvent;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait CommonEvent
{
    use LogsActivity, CommonEvent;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->select('id', 'name');
    }

    public static function bootCreatedBy()
    {
        static::creating(function ($model) {
            event(new CreatedByEvent($model));
        });

        static::updating(function ($model) {
            event(new UpdatedByEvent($model));
        });
    }
}
