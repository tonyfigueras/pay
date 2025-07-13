<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'chapter_id',
        'step_id',
        'completed_course',
        'completed_chapter',
    ];

    public function student(){
        return $this->belongsTo(User::class);
    }
}
