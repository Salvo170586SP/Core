<?php

namespace App\Livewire\Admin\Teachers;

use App\Livewire\Forms\Admin\Teachers\ProfessionalProfile;
use App\Livewire\Forms\Admin\Teachers\TeacherDetails;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeachersCreate extends Component
{
    use WithFileUploads;
    public TeacherDetails $teacherDetailsStep;
    public ProfessionalProfile $professionalProfileStep;
    public $currentStep = 0;

    public function addStep()
    {
        $this->resetValidation();

        if ($this->currentStep == 0) {
            $this->teacherDetailsStep->validate();
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

    public function submit()
    {
        $this->professionalProfileStep->validate();

        $teacher_id =  $this->teacherDetailsStep->save();
        $this->professionalProfileStep->save($teacher_id);

        return  $this->redirect('/professori', navigate: true);
    }


    public function render()
    {
        $levels = config('Core.levels');
         return view('livewire.admin.teachers.teachers-create', compact('levels'));
    }
}
