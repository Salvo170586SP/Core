<?php

namespace App\Livewire\Admin\Students;

use App\Livewire\Forms\Admin\Students\CoursesAddStep;
use App\Livewire\Forms\Admin\Students\StudentDetailsStep;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentsCreate extends Component
{
    use WithFileUploads;
    public StudentDetailsStep $studentDetailsStep;
    public CoursesAddStep $coursesAddStep;
    public $currentStep = 0;

    public function mount()
    {
        $this->studentDetailsStep->generateUniqueCode();
    }

    public function addStep()
    {
        $this->resetValidation();

        if ($this->currentStep == 0) {
            $this->studentDetailsStep->validate();
        }

        $this->currentStep++;
    }

    public function backStep()
    {
        $this->currentStep--;
    }

    public function submit()
    {
        $this->coursesAddStep->validate();
        $student_id = $this->studentDetailsStep->save();
        $this->coursesAddStep->save($student_id);
        
        return  $this->redirect('/allievi', navigate: true);
    }

    public function render()
    {
        $courses = Course::where('status', 'recruitment')->get();
        return view('livewire.admin.students.students-create', compact('courses'));
    }
}
