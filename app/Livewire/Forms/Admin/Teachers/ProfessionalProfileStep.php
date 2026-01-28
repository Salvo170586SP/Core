<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\Document;
use App\Models\ProfessionalProfile as ModelsProfessionalProfile;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;
use Livewire\WithFileUploads;

class ProfessionalProfileStep extends Form
{
    use WithFileUploads;

    public $level_coach;
    public $direct_collaboration;
    public $day_course;
    public $hour_start;
    public $hour_end;
    public $url_file = null;

    protected $rules = [
        'hour_start' => 'nullable|date_format:H:i',
        'hour_end' => 'nullable|date_format:H:i',
        'url_file' => 'nullable|file|mimes:pdf|max:10240'
    ];

    protected $messages = [
        'date_of_birth.date' => 'Il campo deve essere una data',
        'date_of_birth.date_format' => 'Il campo deve essere una data valida',
        'hour_start.date_format' => 'Il campo ora inizio deve essere nel formato HH:MM (es. 14:30)',
        'hour_end.date_format' => 'Il campo ora fine deve essere nel formato HH:MM (es. 18:00)',
        'url_file.file' => 'Il file caricato non è valido',
        'url_file.mimes' => 'Il file deve essere di tipo PDF',
        'url_file.max' => 'Il file non può superare i 10MB',
    ];



    public function save($teacher_id)
    {
        $this->validate();


        ModelsProfessionalProfile::create([
            'teacher_id' => $teacher_id,
            'level_coach' => $this->level_coach,
            'direct_collaboration' => $this->direct_collaboration,
            'day_course' => $this->day_course,
            'hour_start' => $this->hour_start,
            'hour_end' => $this->hour_end,
        ]);

        $filePath = null;

        if ($this->url_file) {
            $originalName = $this->url_file->getClientOriginalName();
            $filePath = $this->url_file->store('documents_teacher', 'public');

            Document::create([
                'teacher_id' => $teacher_id,
                'type' => Document::TYPE_DOC_PROFESSIONALE,
                'name' => $originalName,
                'url_file' => $filePath
            ]);
        }
    }

    public function update($teacher_id)
    {
        $this->validate();

        $profile = ModelsProfessionalProfile::firstOrNew(['teacher_id' => $teacher_id]);
        $profile->level_coach = $this->level_coach;
        $profile->direct_collaboration = $this->direct_collaboration;
        $profile->day_course = $this->day_course;
        $profile->hour_start = $this->hour_start;
        $profile->hour_end = $this->hour_end;
        $profile->save();

        // Gestisci foto solo se è stato caricato
        if ($this->url_file) {
            // Trova il documento esistente
            $document = Document::where('teacher_id', $teacher_id)
                ->where('type', Document::TYPE_DOC_PROFESSIONALE)
                ->first();

            // Se esiste, elimina il vecchio file
            if ($document && $document->url_file) {
                Storage::disk('public')->delete($document->url_file);
            }

            // Salva il nuovo file
            $filePath = $this->url_file->store('documents_teacher', 'public');
            $originalName = $this->url_file->getClientOriginalName();

            // Crea o aggiorna
            Document::updateOrCreate(
                [
                    'teacher_id'  => $teacher_id,
                    'type' => Document::TYPE_DOC_PROFESSIONALE
                ],
                [
                    'name' => $originalName,
                    'url_file' => $filePath
                ]
            );
        }
    }
}
