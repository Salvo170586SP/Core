<?php

namespace App\Livewire\Admin\Teachers;

use App\Models\User;
use Livewire\Component;

class TeachersDetail extends Component
{
    public $id;
    public User $teacher;

    public function mount()
    {
        $this->teacher = User::with('professionalProfile', 'subjects')->findOrFail($this->id);
    }

    public function getCoursesProperty()
    {
        return $this->teacher->getCoursesViaSubjects();
    }

    public function render()
    {
        return view('livewire.admin.teachers.teachers-detail');
    }
}
