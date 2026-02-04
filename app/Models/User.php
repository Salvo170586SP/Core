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
use Carbon\Carbon;

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
        'code',
        'name',
        'email',
        'password',
        'last_login_at'
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
            'last_login_at' => 'datetime'
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

    //materie degli insegnanti
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }

    //corsi degli insegnanti
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');
    }

    //corsi degli studenti
    public function coursesStudents()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->withPivot('is_active', 'badge_number', 'issued_at')
            ->withTimestamps();
    }



    // Documenti dove l'utente è lo studente
    public function documentsAsAdmin()
    {
        return $this->hasMany(Document::class, 'admin_id');
    }

    // Documenti dove l'utente è lo studente
    public function documentsAsStudent()
    {
        return $this->hasMany(Document::class, 'student_id');
    }

    // Documenti dove l'utente è il teacher
    public function documentsAsTeacher()
    {
        return $this->hasMany(Document::class, 'teacher_id');
    }

    // Dettagli dove l'utente è lo studente
    public function detailsAsStudent()
    {
        return $this->hasOne(UserDetail::class, 'student_id');
    }

    // Dettagli dove l'utente è il teacher
    public function detailsAsTeacher()
    {
        return $this->hasOne(UserDetail::class, 'teacher_id');
    }

    // Controlla se lo studente ha ALMENO un tesseramento attivo
    public function getIsBadgeAttribute()
    {
        return $this->coursesStudents()->wherePivot('is_active', true)->exists();
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
  
 


    // prendo colore stato del corso
    public function getDate($date)
    {
        if (!$date) {
            return '-';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}
