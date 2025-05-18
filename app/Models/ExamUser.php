<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamUser extends Model
{
    protected $table = 'exam_users';

    protected $fillable = [
        'exam_id',
        'user_id',
        'user_type'
    ];
}
