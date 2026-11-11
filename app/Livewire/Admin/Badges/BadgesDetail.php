<?php

namespace App\Livewire\Admin\Badges;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BadgesDetail extends Component
{
    use WithPagination;

    public $id;
    public User $student;

    public function mount()
    {
        $this->student = User::role('allievo')->findOrFail($this->id);
    }
  
    public function detachCourseStudent($course_id)
    {
        $course = Course::findOrFail($course_id);
        $course->students()->detach($this->student->id);
    }

    public function render()
    {
        return view('livewire.admin.badges.badges-detail');
    }
}
