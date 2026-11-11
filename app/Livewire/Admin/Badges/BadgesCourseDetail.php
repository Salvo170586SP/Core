<?php

namespace App\Livewire\Admin\Badges;

use App\Models\Course;
use App\Models\User;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QROptions;
use Livewire\Component;


class BadgesCourseDetail extends Component
{
    public $id;
    public $course_id;
    public User $student;
    public Course $course;

    public function mount()
    {
        $this->student = User::role('allievo')->findOrFail($this->id);
        $this->course = Course::findOrFail($this->course_id);
    }

    public function getQrCode()
    {
        $options = new QROptions([
            'outputInterface' => QROutputInterface::MARKUP_SVG,
            'eccLevel' => EccLevel::L,
        ]);

        return (new QRCode($options))->render($this->student->coursesStudents->firstWhere('id', $this->course->id)->pivot->badge_number);
    }

    public function render()
    {
        return view('livewire.admin.badges.badges-course-detail');
    }
}
