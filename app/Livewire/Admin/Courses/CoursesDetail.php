<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;

class CoursesDetail extends Component
{
    public $id;
    public Course $course;

    public function mount()
    {
        $this->course = Course::with('subjects')->findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.admin.courses.courses-detail');
    }
}
