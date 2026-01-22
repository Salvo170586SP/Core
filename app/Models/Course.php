<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'level',
        'duration_hours',
        'max_students',
        'min_students',
        'start_date',
        'end_date',
        'status',
        'location',
        'price',
        'center',
        'certification',
    ];

    protected $casts = [
        'max_students' => 'string',
        'min_students' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'certification' => 'boolean',
    ];

    // Relazione con le materie
    /* public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subject')
            ->withPivot('hours', 'order', 'start_date', 'end_date')
            ->withTimestamps()
            ->orderBy('course_subject.order');
    } */

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class,'course_teacher', 'course_id', 'teacher_id');
    }

    // Tutti i professori del corso (attraverso le materie)
    /*   public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_subject', 'course_id', 'teacher_id')
            ->withPivot('subject_id', 'hours', 'order', 'start_date', 'end_date')
            ->withTimestamps()
            ->distinct();
    } */

    // prendo   livello  del corso
    public function getLevelLabel($levelId)
    {
        $levels_course = collect(config('Core.levels_course'))->firstWhere('id', $levelId);
        return $levels_course['label'] ?? '-';
    }

    // prendo colore livello  del corso
    public function getLevelColor($levelId)
    {
        $levels_course = collect(config('Core.levels_course'))->firstWhere('id', $levelId);
        return $levels_course['color'] ?? '-';
    }

    // prendo stato del corso
    public function getStatusLabel($stateId)
    {
        $status_course = collect(config('Core.status_course'))->firstWhere('id', $stateId);
        return $status_course['label'] ?? '-';
    }

    // prendo colore stato del corso
    public function getStatusColor($stateId)
    {
        $status_course = collect(config('Core.status_course'))->firstWhere('id', $stateId);
        return $status_course['color'] ?? '-';
    }
}
