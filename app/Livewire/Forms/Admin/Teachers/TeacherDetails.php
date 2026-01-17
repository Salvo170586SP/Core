<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TeacherDetails extends Form
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $teacherId = null;


    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($this->teacherId ?? null)],
        ];

        if (!$this->teacherId) {
            $rules['password'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:8';
        }

        return $rules;
    }

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'email.required' => 'Il campo è obbligatorio',
        'email.email' => 'la mail deve essere valida',
        'email.unique' => 'la mail è già presente, inseriscine una nuova',
        'password.required' => 'Il campo è obbligatorio',
    ];

    public function save()
    {
        $this->validate();

        $teacher = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ])->assignRole('istruttore');

        return $teacher->id;
    }

    public function update($teacherId)
    {
        $this->teacherId = $teacherId;
        $this->validate();

        $teacher = User::findOrFail($teacherId);
        $teacher->name = $this->name;
 
        // Aggiorna la password solo se fornita
        if (!empty($this->password)) {
            $teacher->password = bcrypt($this->password);
        }

        $teacher->save();
    }
}
