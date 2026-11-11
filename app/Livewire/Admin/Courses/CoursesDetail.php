<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CoursesDetail extends Component
{
    public $id;
    public Course $course;
    public $selected = [];
    public $selectAll = false;
    public $student_id;
    public $is_active = false;
    public $recruitmentStatus;

    public function updateRecruitmentStatus($courseId, $value)
    {
        $this->course = Course::where('type', 'all')->findOrFail($courseId);
        $this->course->update([
            'recruitment_status' => $value
        ]);
    }

    public function mount()
    {
        $this->course = Course::with(['subjects', 'students'])->findOrFail($this->id);
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
        $data = [
            'is_active' => (bool) $this->is_active,
        ];

        if ($this->is_active) {
            $data['issued_at'] = now();
            $data['badge_number'] = $this->generateUniqueBadgeNumber();
        }

        $this->course->students()->attach($this->student_id, $data);

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
            $this->course->recruitment_status = 'recruitment_closed';
        } else if ($this->course->students()->count() < 3) {
            $this->course->recruitment_status = 'recruitment';
        }
        $this->course->save();
    }

    public function toggleBadge($studentId)
    {
        $student = $this->course->students()->find($studentId);

        if ($student) {
            $newIsActive = !$student->pivot->is_active;

            $data = [
                'is_active' => $newIsActive,
            ];

            if ($newIsActive) {
                $data['issued_at'] = now();
                $data['badge_number'] = $this->generateUniqueBadgeNumber();
            } else {
                $data['issued_at'] = null;
                $data['badge_number'] = null;
            }

            $this->course->students()->updateExistingPivot($studentId, $data);
        }
    }

    public function render()
    {
        $courseId = $this->id;
        $students = User::role('allievo')
            ->whereDoesntHave('coursesStudents', function ($query) use ($courseId) {
                $query->where('courses.id', $courseId);
            })
            ->get();

        $recruitments_state = config('Core.recruitments_state');

        return view('livewire.admin.courses.courses-detail', compact('students', 'recruitments_state'));
    }
}
