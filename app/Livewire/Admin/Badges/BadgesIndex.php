<?php

namespace App\Livewire\Admin\Badges;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class BadgesIndex extends Component
{
    use WithPagination;
    
    public function render()
    {
        // Recupera gli studenti che hanno il tesseramento attivo nella pivot course_student
        $badge_student = User::role('allievo')->whereHas('coursesStudents', function ($query) {
            $query->where('course_student.is_active', true);
        })->paginate(10);

        return view('livewire.admin.badges.badges-index', compact('badge_student'));
    }
}
