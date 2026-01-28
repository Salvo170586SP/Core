<?php

namespace App\Livewire\Admin\Documents;

use App\Models\User;
use Livewire\Component;

class DocumentsIndex extends Component
{
    public function render()
    {
        $studentDocuments = User::role('allievo')->latest()->get();
        $teacherDocuments = User::role('istruttore')->latest()->get(); 

        return view('livewire.admin.documents.documents-index', compact('studentDocuments', 'teacherDocuments'));
    }
}
