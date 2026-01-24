<?php

namespace App\Livewire\Admin\EveningCourses;

use App\Models\Course;
use App\Models\User;
use Livewire\Component;

class EveningCoursesDetail extends Component
{
    public $id;
    public Course $course;
    public $selected = [];
    public $selectAll = false;
    public $student_id;


    public function mount()
    {
        $this->course = Course::where('type', 'evening')->with(['subjects', 'students'])->findOrFail($this->id);
    }

    public function updatedSelected()
    {
        $totalStudents = User::role('allievo')->count();
        $this->selectAll = count($this->selected) === $totalStudents && $totalStudents > 0;
    }

    public function detachStudentCourse($student_id)
    {
        $student = User::findOrFail($student_id);
        $this->course->students()->detach($student->id);
        $this->toggleRecruitment();
    }

    public function detachSelectedStudentCourse()
    {
        if (empty($this->selected)) {
            return;
        }

        $this->course->students()->detach($this->selected);
        $this->selected = [];
        $this->toggleRecruitment();
    }

    public function attachStudentCourse()
    {
        $this->course->students()->attach($this->student_id);

        $this->toggleRecruitment();
    }

    public function clearSelection()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function toggleRecruitment()
    {
        if ($this->course->students()->count() == 3) {
            $this->course->status = 'recruitment_closed';
        } else if ($this->course->students()->count() < 3) {
            $this->course->status = 'recruitment';
        }
        $this->course->save();
    }

    public function render()
    {
        $courseId = $this->course->id;
        $students = User::role('allievo')
            ->whereDoesntHave('coursesStudents', function ($query) use ($courseId) {
                $query->where('courses.id', $courseId);
            })
            ->get();

        return view('livewire.admin.evening-courses.evening-courses-detail', compact('students'));
    }
}
