<?php

namespace App\Livewire\Forms\Admin\Teachers;

use App\Models\Document;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TeacherDetailsStep extends Form
{
    public $code;
    public $name = '';
    public $email = '';
    public $password = 'password';
    public $teacherId = null;
    public $url_photo = null;

    public $fiscal_code;
    public $city;
    public $cap;
    public $city_birth;
    public $date_birth;
    public $phone_number;
    public $note;


    protected function rules()
    {
        $rules = [
            'code' => 'unique:courses',
            'name' => 'required',
            'email' => ['required', 'email',  Rule::unique('users', 'email')->ignore($this->teacherId ?? null)],
            'url_photo' => 'nullable|file|max:10240',
            'fiscal_code' => 'nullable',
            'city' => 'nullable',
            'cap' => 'nullable|numeric',
            'city_birth' => 'nullable',
            'date_birth' => 'nullable|date_format:Y-m-d',
            'phone_number' => 'nullable|numeric',
            'note' => 'nullable|max:500',
        ];

        if (!$this->teacherId) {
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
        'url_photo.file' => 'Il file caricato non è valido',
        'url_photo.max' => 'Il file non può superare i 10MB',
        'cap.numeric' => 'il campo deve contenere numeri',
        'date_birth.date_format' => 'il campo deve contenere una data',
        'phone_number.numeric' => 'il campo deve contenere numeri',
        'note.max' => 'il campo non può avere più di :max caratteri',
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

        $teacher = User::create([
            'code' => $this->generateUniqueCode(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ])->assignRole('istruttore');

        UserDetail::create([
            'teacher_id' => $teacher->id,
            'fiscal_code' => $this->fiscal_code,
            'city' => $this->city,
            'cap' => $this->cap,
            'city_birth' => $this->city_birth,
            'date_birth' => $this->date_birth,
            'phone_number' => $this->phone_number,
            'note' => $this->note,
        ]);


        $filePhotoPath = null;
        if ($this->url_photo) {
            $originalPhotoName = $this->url_photo->getClientOriginalName();
            $filePhotoPath = $this->url_photo->store('documents_teacher', 'public');

            Document::create([
                'teacher_id' => $teacher->id,
                'type' => Document::TYPE_FOTO_PROFILO,
                'name' => $originalPhotoName,
                'url_file' => $filePhotoPath
            ]);
        }

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

        UserDetail::updateOrCreate(
            [
                // Trova per student_id
                'teacher_id' => $teacher->id,
            ],
            [
                // Campi da aggiornare/creare
                'fiscal_code' => $this->fiscal_code,
                'city' => $this->city,
                'cap' => $this->cap,
                'city_birth' => $this->city_birth,
                'date_birth' => $this->date_birth,
                'phone_number' => $this->phone_number,
                'note' => $this->note,
            ]
        );

        // Gestisci foto solo se è stato caricato
        if ($this->url_photo) {
            // Trova il documento esistente
            $document = Document::where('teacher_id', $teacher->id)
                ->where('type', Document::TYPE_FOTO_PROFILO)
                ->first();

            // Se esiste, elimina il vecchio file
            if ($document && $document->url_photo) {
                Storage::disk('public')->delete($document->url_photo);
            }

            // Salva il nuovo file
            $filePathPhoto = $this->url_photo->store('documents_teacher', 'public');
            $originalPhotoName = $this->url_photo->getClientOriginalName();

            // Crea o aggiorna
            Document::updateOrCreate(
                [
                    'teacher_id'  => $teacher->id,
                    'type' => Document::TYPE_FOTO_PROFILO
                ],
                [
                    'name' => $originalPhotoName,
                    'url_file' => $filePathPhoto
                ]
            );
        }

        $teacher->save();
    }
}
