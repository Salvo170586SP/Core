<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'student_id',
        'social',
        'you_tube',
        'word_mouth',
        'research',
        'google',
        'other',
    ];

    //ha un studente (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
