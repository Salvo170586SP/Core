<?php

namespace App\Livewire\Admin\MyAccount;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MyStudents extends Component
{
    public function render()
    {
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

     
        $students = User::whereHas('coursesStudents', function ($query) {
            $query->whereIn('course_id', function ($subQuery) {
                $subQuery->select('courses.id')
                    ->from('courses')
                    ->join('course_subject', 'courses.id', '=', 'course_subject.course_id')
                    ->join('subjects', 'course_subject.subject_id', '=', 'subjects.id')
                    ->join('subject_teacher', 'subjects.id', '=', 'subject_teacher.subject_id')
                    ->where('subject_teacher.teacher_id', auth()->id());
            });
        })->get();

        return view('livewire.admin.my-account.my-students', compact('totalStudents', 'students'));
    }
}
