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
        $this->studentDetailsStep->email = $this->student->email;
        $this->studentDetailsStep->password = '';
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
