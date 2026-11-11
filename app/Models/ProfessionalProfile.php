<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    protected $fillable = [
        'teacher_id',
        'file_professional',
        'original_name',
        'level_coach',
        'day_course',
        'hour_start',
        'hour_end',
    ];

    protected function casts(): array
    {
        return [
            'hour_start' => \App\Casts\TimeHhMm::class,
            'hour_end' => \App\Casts\TimeHhMm::class,
        ];
    }

    //ha un professore (user)
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function formattedUpdatedAt()
    {
        Carbon::setLocale('it');
        return Carbon::parse($this->updated_at)->isoFormat('D MMM YYYY');
    }
}
