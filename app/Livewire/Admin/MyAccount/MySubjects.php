<?php

namespace App\Livewire\Admin\MyAccount;

use Livewire\Component;

class MySubjects extends Component
{
    public function render()
    {
        $subjects = auth()->user()->subjects()->get();

        return view('livewire.admin.my-account.my-subjects', compact('subjects'));
    }
}
