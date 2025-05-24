<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaravelLoggerActivity extends Model
{
    protected $table = 'laravel_logger_activity';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId')->select('id', 'name');
    }
}
