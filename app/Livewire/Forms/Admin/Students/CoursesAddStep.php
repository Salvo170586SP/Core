<?php

namespace App\Livewire\Forms\Admin\Students;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CoursesAddStep extends Form
{
    #[Validate('array|min:1')]
    public $courses_selected = [];

    protected $messages = [
        'courses_selected.array' => 'Il campo è un array.',
        'courses_selected.min' => 'Devi selezionare almeno 1 corso',
    ];

    public function save($student_id)
    {
        $this->validate();
        $student = User::findOrFail($student_id);
        if (!empty($this->courses_selected)) {
            $student->coursesStudents()->attach($this->courses_selected);
        }
    }
}