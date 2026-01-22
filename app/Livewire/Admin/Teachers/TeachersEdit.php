<?php

namespace App\Livewire\Admin\Teachers;

use App\Livewire\Forms\Admin\Teachers\ProfessionalProfileStep;
use App\Livewire\Forms\Admin\Teachers\SubjectsStep;
use App\Livewire\Forms\Admin\Teachers\TeacherDetailsStep;
use App\Models\Subject;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeachersEdit extends Component
{
    use WithFileUploads;

    public $id;
    public User $teacher;
    public TeacherDetailsStep $teacherDetailsStep;
    public ProfessionalProfileStep $professionalProfileStep;
    public SubjectsStep $subjectsStep;
    public array $subjects_selected = [];


    public function mount()
    {
        $this->teacher = User::with('professionalProfile', 'subjects')->findOrFail($this->id);

        // Carica i dati anagrafici
        $this->teacherDetailsStep->name = $this->teacher->name;
        $this->teacherDetailsStep->email = $this->teacher->email;
        $this->teacherDetailsStep->password = '';

        // Carica il profilo professionale se esiste
        if ($this->teacher->professionalProfile) {
            $profile = $this->teacher->professionalProfile;
            $this->professionalProfileStep->center = $profile->center;
            $this->professionalProfileStep->level_coach = $profile->level_coach;
            $this->professionalProfileStep->day_course = $profile->day_course;
            $this->professionalProfileStep->hour_start = $profile->hour_start;
            $this->professionalProfileStep->hour_end = $profile->hour_end;
            $this->professionalProfileStep->direct_collaboration = $profile->direct_collaboration;
        }

        // Carica i subjects attuali del professore
        $this->subjects_selected = $this->teacher->subjects->pluck('id')->toArray();
    }

    public function getLevelLabel($levelId)
    {
        $levels = config('Core.levels', []);
        $level = collect($levels)->firstWhere('id', $levelId);
        return $level['label'] ?? '-';
    }

    public function submit()
    {
        $this->teacherDetailsStep->update($this->teacher->id);
        $this->professionalProfileStep->update($this->teacher->id);

        // Sincronizza i subjects
        $this->teacher->subjects()->sync($this->subjects_selected);

        return $this->redirect('/professori', navigate: true);
    }

    public function render()
    {
        $levels = config('Core.levels');
        $subjects = Subject::all();
        return view('livewire.admin.teachers.teachers-edit', compact('levels', 'subjects'));
    }
}
