<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'course_id',
        'student_id',
        'social',
        'you_tube',
        'word_mouth',
        'research',
        'google',
        'other',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    //ha un studente (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
