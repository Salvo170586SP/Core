<?php

namespace App\Livewire\Admin;

use App\Events\StudentRegistered;
use App\Mail\SendOtpMail;
use App\Mail\SuccessSubscribeMail;
use App\Models\Course;
use App\Models\Document;
use App\Models\Feedback;
use App\Models\User;
use App\Models\UserDetail;
use App\Notifications\NewStudentRegistered;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class CourseModule extends Component
{
    public Course $course;
    public $formSubmitted = false;

    public $name;
    public $city_birth;
    public $date_birth;
    public $city;
    public $cap;
    public $fiscal_code;
    public $phone_number;
    public $email;

    // OTP properties
    public $otp;
    public $enteredOtp;
    public $otpSent = false;
    public $isVerified = false;

    public $social;
    public $youTube;
    public $wordMmouth;
    public $research;
    public $google;
    public $other;

    public $autorizza;

    public $isSubmitting = false;
    public $confirmSubmission = false;
    public $otpError = null;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    protected $rules = [
        'name' => 'required',
        'city_birth' => 'required',
        'date_birth' => 'required|date|date_format:Y-m-d',
        'city' => 'required',
        'cap' => 'required',
        'fiscal_code' => 'required|string|unique:user_details,fiscal_code|regex:/^[A-Z0-9]+$/i',
        // 'fiscal_code' => 'required|string|size:16|unique:users,fiscal_code|regex:/^[A-Z0-9]+$/i',
        'phone_number' => 'required',
        'email' => 'required|email|unique:users,email',
        'autorizza' => 'required|in:yes',
    ];

    protected $messages = [
        'name.required' => 'il campo è obbligatorio',
        'city_birth.required' => 'il campo è obbligatorio',
        'date_birth.required' => 'il campo è obbligatorio',
        'date_birth.date' => 'il campo deve essere una data',
        'date_birth.date_format' => 'il campo deve essere una data valida',
        'city.required' => 'il campo è obbligatorio',
        'cap.required' => 'il campo è obbligatorio',
        'fiscal_code.required' => 'il campo è obbligatorio',
        /*  'fiscal_code.size' => 'Il codice fiscale deve essere di 16 caratteri', */
        'fiscal_code.regex' => 'Il codice fiscale può contenere solo lettere e numeri',
        'fiscal_code.unique' => 'Il codice fiscale esiste già nel nostro archivio',
        'phone_number.required' => 'il campo è obbligatorio',
        'email.required' => 'il campo è obbligatorio',
        'email.email' => 'la mail deve essere valida',
        'email.unique' => 'la mail esiste, inseriscine una nuova',
        'autorizza.required' => 'il campo è obbligatorio, devi accettare il consenso',
        'autorizza.in' => 'devi accettare il consenso',
    ];

    public function sendOtp()
    {
        $this->validate();

        $this->otp = rand(100000, 999999); // Genera OTP
        session()->put('otp', $this->otp); // Salva OTP in sessione

        // Invia email con OTP
        /*    Mail::to($this->email)->send(new SendOtpMail($this->otp)); */

        $this->otpSent = true;
        session()->flash('success', 'Il codice OTP è stato inviato alla tua email.');
    }


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



    public function saveModule()
    {
        if (!$this->isVerified) {
            session()->flash('error', 'Devi completare la verifica OTP per procedere.');
            return;
        }

        $this->isSubmitting = true;

        $this->validate();

        $student = User::create([
            'code' => $this->generateUniqueCode(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'),
        ])->assignRole('allievo');

        UserDetail::create([
            'student_id' => $student->id,
            'city_birth' => $this->city_birth,
            'date_birth' => $this->date_birth,
            'city' => $this->city,
            'cap' => $this->cap,
            'fiscal_code' => $this->fiscal_code,
            'phone_number' => $this->phone_number,
        ]);

        //AGGIUNGE ALLIEVO AL CORSO
        if ($this->course->id && $student) {
            $student->coursesStudents()->attach($this->course->id, [
                'issued_at' => $student->created_at,
                'is_active' => 0,
                'badge_number' => null,
            ]);
        }



        /*    Mail::to($this->email)->send(new SuccessSubscribeMail($this->name, $this->course)); */

        //Prepara i dati da passare alla vista del PDF
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'city_birth' => $this->city_birth,
            'date_birth' => $this->date_birth,
            'city' => $this->city,
            'cap' => $this->cap,
            'fiscal_code' => $this->fiscal_code,
            'phone_number' => $this->phone_number,
            'social' => $this->social,
            'youTube' => $this->youTube,
            'wordMmouth' => $this->wordMmouth,
            'research' => $this->research,
            'google' => $this->google,
            'other' => $this->other,
        ];

        // Configura Dompdf
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        // Genera l'HTML della vista
        $html = view('livewire.admin.pdf.module-trainee', $data)->render();

        // Carica l'HTML in Dompdf
        $dompdf->loadHtml($html);

        // Imposta il formato della pagina
        $dompdf->setPaper('A4', 'portrait');

        // Renderizza il PDF
        $dompdf->render();

        // Ottieni il contenuto del PDF generato
        $pdfContent = $dompdf->output();

        // Definisci il nome del file e la directory di salvataggio
        $fileName = 'modulo-iscrizione-' . $this->name . '.pdf';
        $filePath = 'documents_student/' . $fileName;
        Storage::disk('public')->put($filePath, $pdfContent);


        Document::create([
            'student_id' => $student->id,
            'type' => Document::TYPE_MODULO_PDF,
            'name' => $fileName,
            'url_file' => $filePath,
        ]);

        Feedback::create([
            'course_id' => $this->course->id,
            'student_id' => $student->id,
            'social' => $this->social,
            'you_tube' => $this->youTube,
            'word_mouth' => $this->wordMmouth,
            'research' => $this->research,
            'google' => $this->google,
            'other' => $this->other
        ]);

        $this->formSubmitted = true;

        // Eventuale messaggio di successo (opzionale)
        $this->dispatch('messageUploadMoudule');

        if (auth()->user()->notification_preferences == true) {
            // Invia notifica all'amministratore
            $admin = User::role('amministratore')->first();
            $admin->notify(new NewStudentRegistered($student));
            // Broadcast evento real-time
            broadcast(new StudentRegistered($student));
        }
    }

    public function verifyOtp()
    {
        if (session()->get('otp') == $this->enteredOtp) {
            $this->isVerified = true;
            session()->forget('otp');
            session()->flash('success', 'OTP verificato con successo.');

            // Invoca automaticamente il metodo saveModule dopo la verifica dell'OTP
            /* $this->saveModule(); */
        } else {
            $this->otpError = 'Il codice OTP non è valido. Riprova.';
        }
    }

    public function render()
    {
        return view('livewire.admin.course-module');
    }
}
