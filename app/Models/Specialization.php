<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = [
        'name',
    ];

    // Se vuoi fare cast automatico a intero
    protected $casts = [
        'year' => 'integer',
    ];

    // Relazione con Teacher (users con ruolo teacher)
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'specialization_teacher', 'specialization_id', 'teacher_id')
            ->withPivot('year')
            ->withTimestamps();
    }
}
