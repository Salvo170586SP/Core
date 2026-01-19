<?php

namespace App\Livewire\Admin\Teachers;

use App\Models\User;
use Livewire\Component;

class TeachersIndex extends Component
{
    public function toggle($teacher_id)
    {
        $teacher = User::findOrFail($teacher_id);
        $teacher->professionalProfile->direct_collaboration = !$teacher->professionalProfile->direct_collaboration;
        $teacher->professionalProfile->save();
    }
/* 
    public function getLevelLabel($levelId)
    {
        $level = collect(config('Core.levels'))->firstWhere('id', $levelId);
        return $level['label'] ?? '-';
    } */

    public function render()
    {
        $teachers = User::role('istruttore')->latest()->get();

        return view('livewire.admin.teachers.teachers-index', compact('teachers'));
    }
}
