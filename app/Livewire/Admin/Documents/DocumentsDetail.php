<?php

namespace App\Livewire\Admin\Documents;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentsDetail extends Component
{
    use WithPagination;

    public $id;
    public User $user;
    public $selected = [];
    public $selectAll = false;

    public function mount()
    {
        $this->user = User::findOrfail($this->id);
    }


    public function updatedSelected()
    {
        $student = $this->user->hasRole('allievo');
        $teacher = $this->user->hasRole('istruttore');

        if ($student) {
            $userDocumentIds = $this->user->documentsAsStudent()
                ->where('student_id', $this->user->id)
                ->pluck('id')
                ->toArray();
        } elseif ($teacher) {
            $userDocumentIds = $this->user->documentsAsTeacher()
                ->where('teacher_id', $this->user->id)
                ->pluck('id')
                ->toArray();
        } else {
            $userDocumentIds = $this->user->documentsAsAdmin()
                ->pluck('id')
                ->toArray();
        }

        // Conta solo gli elementi selezionati che appartengono a questo utente
        $validSelectedCount = count(array_intersect($this->selected, $userDocumentIds));
        $totalCourses = count($userDocumentIds);

        $this->selectAll = $validSelectedCount === $totalCourses && $totalCourses > 0;
    }


    public function updatedSelectAll($value)
    {
        if ($value) {
            $student = $this->user->hasRole('allievo');
            $teacher = $this->user->hasRole('istruttore');

            if ($student) {
                $this->selected = $this->user->documentsAsStudent()
                    ->where('student_id', $this->user->id)
                    ->pluck('id')
                    ->toArray();
            } elseif ($teacher) {
                $this->selected = $this->user->documentsAsTeacher()
                    ->where('teacher_id', $this->user->id)
                    ->pluck('id')
                    ->toArray();
            } else {
                $this->selected = $this->user->documentsAsAdmin()
                    ->pluck('id')
                    ->toArray();
            }
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

        $documents = Document::whereIn('id', $this->selected)
            ->where(function ($query) {
                $query->where('student_id', $this->user->id)
                    ->orWhere('teacher_id', $this->user->id);
            })->get();

        foreach ($documents as $doc) {
            if ($doc->url_file) {
                Storage::disk('public')->delete($doc->url_file);
            }
            $doc->delete();
        }

        $this->selected = [];
    }

    public function deleteDoc($item_id)
    {
        $doc = Document::findOrFail($item_id);

        // Verifica che il documento appartenga all'utente (come student o teacher)
        if ($doc && ($doc->student_id === $this->user->id || $doc->teacher_id === $this->user->id)) {
            if ($doc->url_file) {
                Storage::disk('public')->delete($doc->url_file);
            }
            $doc->delete();
        }

        $this->selected = [];
    }

    public function render()
    {
        $documents = Document::where(function ($query) {
            $query->where('student_id', $this->user->id)
                ->orWhere('teacher_id', $this->user->id);
        })->latest()->paginate(10);

        return view('livewire.admin.documents.documents-detail', compact('documents'));
    }
}
