<?php

namespace App\Livewire\Admin\Teachers;

use App\Livewire\Forms\Admin\Teachers\ProfessionalProfile;
use App\Livewire\Forms\Admin\Teachers\Specializations;
use App\Livewire\Forms\Admin\Teachers\TeacherDetails;
use App\Models\Specialization;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeachersCreate extends Component
{
    use WithFileUploads;
    public TeacherDetails $teacherDetailsStep;
    public ProfessionalProfile $professionalProfileStep;
    public Specializations $specializationStep;
    public $currentStep = 2;

    public function addStep()
    {
        $this->resetValidation();

        if ($this->currentStep == 0) {
            $this->teacherDetailsStep->validate();
        } else if ($this->currentStep == 1) {
            $this->professionalProfileStep->validate();
        } /* else if ($this->currentStep == 2) {
            $this->specializationStep->validate();
        } */

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

    public function openNewSpecialization()
    {
        $this->specializationStep->openNewSpecialization();
    }

    public function closeNewSpecialization($index)
    {
        $this->specializationStep->closeNewSpecialization($index);
    }

    public function submit()
    {
       // Valida solo se ci sono specializzazioni aperte
    if (!empty($this->specializationStep->newSpecialization)) {
        $this->specializationStep->validate();
    }

        $teacher_id =  $this->teacherDetailsStep->save();
        $this->professionalProfileStep->save($teacher_id);
        $this->specializationStep->save($teacher_id);

        return  $this->redirect('/professori', navigate: true);
    }


    public function render()
    {
        $levels = config('Core.levels');
        $specializations = Specialization::all();

        return view('livewire.admin.teachers.teachers-create', compact('levels', 'specializations'));
    }
}
