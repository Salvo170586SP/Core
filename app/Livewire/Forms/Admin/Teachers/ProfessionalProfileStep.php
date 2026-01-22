<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\ProfessionalProfile as ModelsProfessionalProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\WithFileUploads;

class ProfessionalProfileStep extends Form
{
    use WithFileUploads;

    public $file_professional;
    public $level_coach;
    public $direct_collaboration;
    public $center;
    public $day_course;
    public $hour_start;
    public $hour_end;

    protected $rules = [
        'hour_start' => 'nullable|date_format:H:i',
        'hour_end' => 'nullable|date_format:H:i',
        'file_professional' => 'nullable|file|mimes:pdf,doc,docx|max:10240'
    ];

    protected $messages = [
        'date_of_birth.date' => 'Il campo deve essere una data',
        'date_of_birth.date_format' => 'Il campo deve essere una data valida',
        'hour_start.date_format' => 'Il campo ora inizio deve essere nel formato HH:MM (es. 14:30)',
        'hour_end.date_format' => 'Il campo ora fine deve essere nel formato HH:MM (es. 18:00)',
        'file_professional.file' => 'Il file caricato non è valido',
        'file_professional.mimes' => 'Il file deve essere di tipo PDF, DOC o DOCX',
        'file_professional.max' => 'Il file non può superare i 10MB',
    ];



    public function save($teacher_id)
    {
        $this->validate();

        $filePath = null;
        if ($this->file_professional) {
            $filePath = $this->file_professional->store('professional-profiles', 'public');
        }

        ModelsProfessionalProfile::create([
            'teacher_id' => $teacher_id,
            'file_professional' => $filePath,
            'level_coach' => $this->level_coach,
            'direct_collaboration' => $this->direct_collaboration,
            'center' => $this->center,
            'day_course' => $this->day_course,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
        ]);
    }

    public function update($teacher_id)
    {
        $this->validate();

        $profile = ModelsProfessionalProfile::firstOrNew(['teacher_id' => $teacher_id]);

        // Aggiorna il file solo se ne viene caricato uno nuovo
        if ($this->file_professional) {
            // Elimina il vecchio file se esiste
            if ($profile->file_professional && Storage::disk('public')->exists($profile->file_professional)) {
                Storage::disk('public')->delete($profile->file_professional);
            }
            $profile->file_professional = $this->file_professional->store('professional-profiles', 'public');
        }

        $profile->level_coach = $this->level_coach;
        $profile->direct_collaboration = $this->direct_collaboration;
        $profile->center = $this->center;
        $profile->day_course = $this->day_course;
        $profile->hour_start = $this->hour_start;
        $profile->hour_end = $this->hour_end;
        
        $profile->save();
    }
}
