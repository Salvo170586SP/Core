<?php

namespace App\Livewire\Admin\Teachers;

use App\Models\User;
use Livewire\Component;

class TeachersIndex extends Component
{
    public $selected = [];
    public $selectAll = false;

    public function updatedSelected()
    {
        $totalTeachers = User::role('istruttore')->count();
        $this->selectAll = count($this->selected) === $totalTeachers && $totalTeachers > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = User::role('istruttore')->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function toggle($teacher_id)
    {
        $teacher = User::findOrFail($teacher_id);
        $teacher->professionalProfile->direct_collaboration = !$teacher->professionalProfile->direct_collaboration;
        $teacher->professionalProfile->save();
    }

    public function clearSelection()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function deleteSelection()
    {
        if (empty($this->selected)) {
            return;
        }

        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            User::findOrFail($item_id)->delete();
        }
        $this->selected = [];
    }

    public function render()
    {
        $teachers = User::role('istruttore')->latest()->get();

        return view('livewire.admin.teachers.teachers-index', compact('teachers'));
    }
}
