<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'fiscal_code',
        'city',
        'cap',
        'city_birth',
        'date_birth',
        'phone_number',
        'note',
    ];

    protected $casts = [
        'date_birth' => 'date',
    ];

    //ha un professore (user)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    //ha un studente (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
