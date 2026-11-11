<?php

namespace App\Livewire\Forms\Admin\Students;

use App\Mail\SuccessSubscribeMail;
use App\Models\Document;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\RegistrationModuleGenerator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StudentDetailsStep extends Form
{
    public $code;
    public $name;
    public $email;
    public $password = 'password';
    public $studentId = null;
    public $url_photo = null;
    public $url_file = null;

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
            'url_photo' => 'nullable|file|max:10240',
            'url_file' => 'nullable|file|mimes:pdf|max:10240',
            'fiscal_code' => 'nullable',
            'city' => 'nullable',
            'cap' => 'nullable|numeric',
            'city_birth' => 'nullable',
            'date_birth' => 'nullable|date_format:Y-m-d',
            'phone_number' => 'nullable|numeric',
            'note' => 'nullable|max:500',
        ];

        if (!$this->studentId) {
            $rules['email'] = ['required', 'email',  Rule::unique('users', 'email')->ignore($this->studentId ?? null)];
            $rules['password'] = 'required';
        } else {
            $rules['email'] = 'nullable';
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
        'url_file.file' => 'Il file caricato non è valido',
        'url_file.mimes' => 'Il file deve essere di tipo PDF',
        'url_file.max' => 'Il file non può superare i 10MB',
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

        $student = User::create([
            'code' => $this->generateUniqueCode(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ])->assignRole('allievo');

        UserDetail::create([
            'student_id' => $student->id,
            'fiscal_code' => $this->fiscal_code,
            'city' => $this->city,
            'cap' => $this->cap,
            'city_birth' => $this->city_birth,
            'date_birth' => $this->date_birth,
            'phone_number' => $this->phone_number,
            'note' => $this->note,
        ]);

        app(RegistrationModuleGenerator::class)->generate($student);

        $filePath = null;
        if ($this->url_file) {
            $originalName = $this->url_file->getClientOriginalName();
            $filePath = $this->url_file->store('documents_student', 'public');

            Document::create([
                'student_id' => $student->id,
                'type' => Document::TYPE_CARTA_IDENTITA,
                'name' => $originalName,
                'url_file' => $filePath
            ]);
        }

        $filePhotoPath = null;
        if ($this->url_photo) {
            $originalPhotoName = $this->url_photo->getClientOriginalName();
            $filePhotoPath = $this->url_photo->store('documents_student', 'public');

            Document::create([
                'student_id' => $student->id,
                'type' => Document::TYPE_FOTO_PROFILO,
                'name' => $originalPhotoName,
                'url_file' => $filePhotoPath
            ]);
        }

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

        UserDetail::updateOrCreate(
            [
                // Trova per student_id
                'student_id' => $student->id,
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

        // Gestisci il file solo se è stato caricato
        if ($this->url_file) {
            // Trova il documento esistente
            $document = Document::where('student_id', $student->id)
                ->where('type', Document::TYPE_CARTA_IDENTITA)
                ->first();

            // Se esiste, elimina il vecchio file
            if ($document && $document->url_file) {
                Storage::disk('public')->delete($document->url_file);
            }

            // Salva il nuovo file
            $filePath = $this->url_file->store('documents_student', 'public');
            $originalName = $this->url_file->getClientOriginalName();

            // Crea o aggiorna
            Document::updateOrCreate(
                [
                    'student_id'  => $student->id,
                    'type' => Document::TYPE_CARTA_IDENTITA
                ],
                [
                    'name' => $originalName,
                    'url_file' => $filePath
                ]
            );
        }

        // Gestisci foto solo se è stato caricato
        if ($this->url_photo) {
            // Trova il documento esistente
            $document = Document::where('student_id', $student->id)
                ->where('type', Document::TYPE_FOTO_PROFILO)
                ->first();

            // Se esiste, elimina il vecchio file
            if ($document && $document->url_photo) {
                Storage::disk('public')->delete($document->url_photo);
            }

            // Salva il nuovo file
            $filePathPhoto = $this->url_photo->store('documents_student', 'public');
            $originalPhotoName = $this->url_photo->getClientOriginalName();

            // Crea o aggiorna
            Document::updateOrCreate(
                [
                    'student_id'  => $student->id,
                    'type' => Document::TYPE_FOTO_PROFILO
                ],
                [
                    'name' => $originalPhotoName,
                    'url_file' => $filePathPhoto
                ]
            );
        }
    }
}
