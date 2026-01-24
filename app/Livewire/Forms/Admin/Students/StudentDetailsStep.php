<?php

namespace App\Livewire\Forms\Admin\Students;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StudentDetailsStep extends Form
{
    public $code;
    public $name;
    public $email;
    public $password = 'password';
    public $studentId = null;

    protected function rules()
    {
        $rules = [
            'code' => 'unique:courses',
            'name' => 'required',
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($this->studentId ?? null)],
        ];

        if (!$this->studentId) {
            $rules['password'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:8';
        }

        return $rules;
    }

    protected $messages = [
        'code.unique' => 'Il codice esiste già',
        'name.required' => 'Il campo è obbligatorio',
        'email.required' => 'Il campo è obbligatorio',
        'email.email' => 'la mail deve essere valida',
        'email.unique' => 'la mail è già presente, inseriscine una nuova',
        'password.required' => 'Il campo è obbligatorio',
    ];

    public function generateUniqueCode()
    {
        $exists = true;
        $code = "";

        while ($exists) {
            // Genera un codice alfanumerico casuale di 8 caratteri
            $randomPart = strtoupper(bin2hex(random_bytes(4)));
            $code = "#-S" . $randomPart;

            // Verifica se esiste già nel database
            $exists = User::where('code', $code)->exists();
        }

        return $code;
    }


    public function save()
    {
        $this->validate();

        $student = User::create([
            'code' => $this->generateUniqueCode(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ])->assignRole('allievo');

        return $student->id;
    }

    public function update($studentId)
    {
        $this->studentId = $studentId;
        $this->validate();

        $student = User::findOrFail($studentId);
        $student->name = $this->name;

        // Aggiorna la password solo se fornita
        if (!empty($this->password)) {
            $student->password = bcrypt($this->password);
        }

        $student->save();
    }
}
