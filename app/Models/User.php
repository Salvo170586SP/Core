<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Course;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }


    // l'istruttore ha un profilo professionale
    public function professionalProfile()
    {
        return $this->hasOne(ProfessionalProfile::class, 'teacher_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');
    }

    // prendo livello professionale
    public function getLevelLabel($levelId)
    {
        $level = collect(config('Core.levels'))->firstWhere('id', $levelId);
        return $level['label'] ?? '-';
    }

    /**
     * Recupera i corsi in cui l'insegnante insegna tramite le materie
     */
    public function getCoursesViaSubjects()
    {
        return Course::query()
            ->join('course_subject', 'courses.id', '=', 'course_subject.course_id')
            ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->join('subject_teacher', 'subjects.id', '=', 'subject_teacher.subject_id')
            ->where('subject_teacher.teacher_id', $this->id)
            ->select('courses.*')
            ->distinct()
            ->get();
    }
}
