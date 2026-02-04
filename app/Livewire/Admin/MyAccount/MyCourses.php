<?php

namespace App\Livewire\Admin\MyAccount;

use Livewire\Component;

class MyCourses extends Component
{
    public function render()
    {
        $courses = auth()->user()->getCoursesViaSubjects();
        $coursesStudent = auth()->user()->coursesStudents()->get();
        return view('livewire.admin.my-account.my-courses', compact('courses', 'coursesStudent'));
    }
}
