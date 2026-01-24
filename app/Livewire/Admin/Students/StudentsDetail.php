<?php

namespace App\Livewire\Admin\Students;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsDetail extends Component
{
    use WithPagination;

    public $id;
    public User $student;

    public function mount()
    {
        $this->student = User::role('allievo')->findOrFail($this->id);
    }


    public function render()
    {
        $coursesStudents = $this->student->coursesStudents()->paginate();

        return view('livewire.admin.students.students-detail', compact('coursesStudents'));
    }
}
