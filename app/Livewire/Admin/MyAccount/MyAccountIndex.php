<?php

namespace App\Livewire\Admin\MyAccount;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyAccountIndex extends Component
{


    public function render()
    {
        $totalCourses = auth()->user()->getCoursesViaSubjects()->count();
        $totalCoursesStudent = auth()->user()->coursesStudents()->count();

        $totalStudents = DB::table('course_student')
            ->whereIn('course_id', function ($query) {
                $query->select('courses.id')
                    ->from('courses')
                    ->join('course_subject', 'courses.id', '=', 'course_subject.course_id')
                    ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
                    ->join('subject_teacher', 'subjects.id', '=', 'subject_teacher.subject_id')
                    ->where('subject_teacher.teacher_id', auth()->id());
            })
            ->distinct('student_id')
            ->count('student_id');
   

        return view('livewire.admin.my-account.my-account-index', compact('totalCourses', 'totalStudents', 'totalCoursesStudent'));
    }
}
