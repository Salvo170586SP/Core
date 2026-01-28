<?php

namespace App\Livewire\Admin\Students;

use App\Livewire\Forms\Admin\Students\StudentDetailsStep;
use App\Models\Course;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentsEdit extends Component
{
    use WithFileUploads;
    public StudentDetailsStep $studentDetailsStep;
    public $id;
    public User $student;


    public function mount()
    {
        $this->student = User::role('allievo')->findOrFail($this->id);

        $this->studentDetailsStep->name = $this->student->name;
        $this->studentDetailsStep->password = '';

        $this->studentDetailsStep->cap = $this->student->detailsAsStudent?->cap;
        $this->studentDetailsStep->city = $this->student->detailsAsStudent?->city;
        $this->studentDetailsStep->city_birth = $this->student->detailsAsStudent?->city_birth;
        $this->studentDetailsStep->date_birth = $this->student->detailsAsStudent?->date_birth
            ? $this->student->detailsAsStudent->date_birth->format('Y-m-d')
            : null;
        $this->studentDetailsStep->fiscal_code = $this->student->detailsAsStudent?->fiscal_code;
        $this->studentDetailsStep->phone_number = $this->student->detailsAsStudent?->phone_number;
        $this->studentDetailsStep->note = $this->student->detailsAsStudent?->note;
    }

    public function submit()
    {
        $this->studentDetailsStep->update($this->student->id);
        return $this->redirect('/allievi', navigate: true);
    }


    public function render()
    {
        $courses = Course::where('status', 'recruitment')->get();
        return view('livewire.admin.students.students-edit', compact('courses'));
    }
}
