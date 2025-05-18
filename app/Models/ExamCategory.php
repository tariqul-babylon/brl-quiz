<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamCategory extends Model
{
    use SoftDeletes;

    protected $table = 'exam_categories';

    protected $fillable = [
        'name',
        'parent_id',
        'created_by',
    ];

    public function parent(){
        return $this->belongsTo(ExamCategory::class, 'parent_id', 'id');
    }
}
