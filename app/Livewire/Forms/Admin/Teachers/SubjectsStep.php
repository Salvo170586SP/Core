<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectsStep extends Form
{
    public $newSubject = [];


    protected function rules()
    {
        // Se non ci sono specializzazioni aperte, non validare nulla
        if (empty($this->newSubject)) {
            return [];
        }

        // Valida ogni specializzazione nell'array
        $rules = [];
        foreach ($this->newSubject as $index => $sub) {
            $rules["newSubject.{$index}.subject_id"] = 'required|exists:subjects,id';
            /*  $rules["newSubject.{$index}.year"] = 'required|digits:4|integer|min:1900|max:2155'; */
        }

        return $rules;
    }

    protected $messages = [
        'newSubject.*.subject_id.required' => 'Il campo è obbligatorio.',
        'newSubject.*.subject_id.exists' => 'Materia non valida.',
        /*   'newSubject.*.year.required' => 'L\'anno è obbligatorio.',
        'newSubject.*.year.digits' => 'L\'anno deve essere di 4 cifre.',
        'newSubject.*.year.integer' => 'L\'anno deve essere un numero.',
        'newSubject.*.year.min' => 'L\'anno deve essere almeno :min.',
        'newSubject.*.year.max' => 'L\'anno non può essere superiore a :max.', */
    ];


    public function openNewSubject()
    {
        $this->newSubject[] = [
            'subject_id' => '',
            /* 'year' => '' */
        ];
    }

    public function closeNewSubject($index)
    {
        unset($this->newSubject[$index]);
        $this->newSubject = array_values($this->newSubject);
    }

    public function save($teacher_id)
    {
        // Valida solo se ci sono materie
        if (!empty($this->newSubject)) {
            $this->validate();
        }

        $teacher = User::findOrFail($teacher_id);

        // Raccoglie gli ID delle materie da aggiungere
        $subjectIds = [];
        foreach ($this->newSubject as $sub) {
            if (!empty($sub['subject_id'])) {
                $subjectIds[] = $sub['subject_id'];
            }
        }

        // Sincronizza le materie senza staccare le esistenti (aggiunge nuove, non rimuove)
        if (!empty($subjectIds)) {
            $teacher->subjects()->syncWithoutDetaching($subjectIds);
        }
    }
}
