<?php

namespace App\Livewire\Admin\EveningCourses;

use App\Models\Course;
use App\Models\User;
use FFI;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EveningCoursesDetail extends Component
{
    public $id;
    public Course $course;
    public $selected = [];
    public $selectAll = false;
    public $student_id;
    public $is_active = false;

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

    private function generateUniqueBadgeNumber()
    {
        do {
            // Genera un codice alfanumerico casuale (es: "A7K9M2X5")
            $badgeNumber = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));

            // Verifica se esiste già
            $exists = DB::table('course_student')
                ->where('badge_number', $badgeNumber)
                ->exists();
        } while ($exists);

        return $badgeNumber;
    }

    public function attachStudentCourse()
    {
        $this->course->students()->attach($this->student_id, [
            'is_active' => (bool) $this->is_active,
            'issued_at' => now(),
            'badge_number' => $this->generateUniqueBadgeNumber(),
        ]);

        $this->toggleRecruitment();
        $this->is_active = false;
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

    public function toggleBadge($studentId)
    {
        $student = $this->course->students()->find($studentId);

        if ($student) {
            $this->course->students()->updateExistingPivot(
                $studentId,
                ['is_active' => !$student->pivot->is_active]
            );
        }
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
