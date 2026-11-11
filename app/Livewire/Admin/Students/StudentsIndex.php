<?php

namespace App\Livewire\Admin\Students;

use App\Mail\SubscribeLinkMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsIndex extends Component
{
    use WithPagination;
    public $selected = [];
    public $selectAll = false;
    public string $email = '';

    public function sendSubscriptionMail()
    {
        $this->validate([
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L\'indirizzo email è obbligatorio.',
            'email.email' => 'Inserisci un indirizzo email valido.',
            'email.max' => 'L\'email non può superare 255 caratteri.',
        ]);

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

    public function updatedSelected()
    {
        $totalStudents = User::role('allievo')->count();
        $this->selectAll = count($this->selected) === $totalStudents && $totalStudents > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = User::role('allievo')->pluck('id')->toArray();
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

        User::whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            User::findOrFail($item_id)->delete();
        }
        $this->selected = [];
    }

    public function render()
    {
        $students = User::role('allievo')->latest()->paginate(10);
        return view('livewire.admin.students.students-index', compact('students'));
    }
}
