<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Specializations extends Form
{
    public $newSpecialization = [];
    /*  public $name;
    public $year;

       protected $rules = [
        'name' => 'required',
        'year' => 'required|digits:4|integer|min:1900|max:2155',
    ]; */

    protected function rules()
    {
        // Se non ci sono specializzazioni aperte, non validare nulla
        if (empty($this->newSpecialization)) {
            return [];
        }

        // Valida ogni specializzazione nell'array
        $rules = [];
        foreach ($this->newSpecialization as $index => $spec) {
            $rules["newSpecialization.{$index}.name"] = 'required|exists:specializations,id';
            $rules["newSpecialization.{$index}.year"] = 'required|digits:4|integer|min:1900|max:2155';
        }

        return $rules;
    }

    protected $messages = [
        'newSpecialization.*.name.required' => 'La specializzazione è obbligatoria.',
        'newSpecialization.*.name.exists' => 'Specializzazione non valida.',
        'newSpecialization.*.year.required' => 'L\'anno è obbligatorio.',
        'newSpecialization.*.year.digits' => 'L\'anno deve essere di 4 cifre.',
        'newSpecialization.*.year.integer' => 'L\'anno deve essere un numero.',
        'newSpecialization.*.year.min' => 'L\'anno deve essere almeno :min.',
        'newSpecialization.*.year.max' => 'L\'anno non può essere superiore a :max.',
    ];


    public function openNewSpecialization()
    {
        $this->newSpecialization[] = [
            'name' => '',
            'year' => ''
        ];
    }

    public function closeNewSpecialization($index)
    {
        unset($this->newSpecialization[$index]);
        $this->newSpecialization = array_values($this->newSpecialization);
    }

    public function save($teacher_id)
    {
          // Valida solo se ci sono specializzazioni
        if (!empty($this->newSpecialization)) {
            $this->validate();
        }

        $teacher = User::findOrFail($teacher_id);

        $syncData = [];
        foreach ($this->newSpecialization as $spec) {
            if (!empty($spec['name']) && !empty($spec['year'])) {
                $teacher->specializations()->attach($spec['name'], ['year' => $spec['year']]);
            }
        }
    }
}
