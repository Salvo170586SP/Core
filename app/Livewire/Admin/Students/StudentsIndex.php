<?php

namespace App\Livewire\Admin\Students;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsIndex extends Component
{
    use WithPagination;
    public $selected = [];
    public $selectAll = false;

    public function updatedSelected()
    {
        $totalStudents = User::role('allievo')->count();
        $this->selectAll = count($this->selected) === $totalStudents && $totalStudents > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = User::role('allievo')->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
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
        $students = User::role('allievo')->latest()->paginate(10);
        return view('livewire.admin.students.students-index', compact('students'));
    }
}
