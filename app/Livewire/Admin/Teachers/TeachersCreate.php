<?php

namespace App\Livewire\Admin\Teachers;

use App\Livewire\Forms\Admin\Teachers\ProfessionalProfileStep;
use App\Livewire\Forms\Admin\Teachers\SubjectsStep;
use App\Livewire\Forms\Admin\Teachers\TeacherDetailsStep;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeachersCreate extends Component
{
    use WithFileUploads;
    public TeacherDetailsStep $teacherDetailsStep;
    public ProfessionalProfileStep $professionalProfileStep;
    public SubjectsStep $subjectsStep;
    public $currentStep = 0;

    public function addStep()
    {
        $this->resetValidation();

        if ($this->currentStep == 0) {
            $this->teacherDetailsStep->validate();
        } else if ($this->currentStep == 1) {
            $this->professionalProfileStep->validate();
        }  
        $this->currentStep++;
    }

    public function backStep()
    {
        $this->currentStep--;
    }

    public function getLevelLabel($levelId)
    {
        $levels = config('Core.levels', []);
        $level = collect($levels)->firstWhere('id', $levelId);
        return $level['label'] ?? '-';
    }

    public function openNewSubject()
    {
        $this->subjectsStep->openNewSubject();
    }

    public function closeNewSubject($index)
    {
        $this->subjectsStep->closeNewSubject($index);
    }

    public function submit()
    {
       // Valida solo se ci sono specializzazioni aperte
    if (!empty($this->subjectsStep->newSubject)) {
        $this->subjectsStep->validate();
    }

        $teacher_id =  $this->teacherDetailsStep->save();
        $this->professionalProfileStep->save($teacher_id);
        $this->subjectsStep->save($teacher_id);

        return  $this->redirect('/professori', navigate: true);
    }


    public function render()
    {
        $levels = config('Core.levels');
        $subjects = Subject::all();

        return view('livewire.admin.teachers.teachers-create', compact('levels', 'subjects'));
    }
}
