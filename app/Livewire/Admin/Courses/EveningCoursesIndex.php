<?php

namespace App\Livewire\Admin\Courses;

use App\Mail\SubscribeLinkMail;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class EveningCoursesIndex extends Component
{
    use WithPagination;

    public $selected = [];
    public $selectAll = false;
    public $recruitmentStatus = [];
    public $email = '';
    public $courseIdForMail; // ID del corso per cui inviare la mail

    public function updateRecruitmentStatus($courseId, $value)
    {
        $course = Course::where('type', 'evening')->findOrFail($courseId);
        $course->update([
            'recruitment_status' => $value
        ]);
    }

    public function updatedSelected()
    {
        $totalCourses = Course::where('type', 'evening')->count();
        $this->selectAll = count($this->selected) === $totalCourses && $totalCourses > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Course::where('type', 'evening')->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function clearSelection()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function deleteSelection()
    {
        if (empty($this->selected)) {
            return;
        }

        Course::where('type', 'evening')->whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            Course::where('type', 'evening')->findOrFail($item_id)->delete();
        }

        $this->selected = [];
    }

    public function sendSubscriptionMail()
    {
        $this->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L\'indirizzo email è obbligatorio.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'email.max' => 'L\'email non può superare 255 caratteri.',
        ]);

        // Genera il link di iscrizione (adatta questo URL alla tua applicazione)
        $subscribeLink = route('module-courses', [
            'token' => encrypt($this->email)
        ]);

        // Invia la mail
        Mail::to($this->email)->send(
            new SubscribeLinkMail($subscribeLink)
        );

        // Reset del campo
        $this->email = '';

        // Notifica di successo
        session()->flash('message', 'Mail inviata con successo');
    }

    public function render()
    {
        $evening_courses = Course::where('type', 'evening')->with('subjects')->latest()->paginate(10);
        $recruitments_state = config('Core.recruitments_state');
        return view('livewire.admin.courses.evening-courses-index', compact('evening_courses', 'recruitments_state'));
    }
}
