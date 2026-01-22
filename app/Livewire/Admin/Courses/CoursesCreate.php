<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Subject;
use Livewire\Component;

class CoursesCreate extends Component
{


    public $name = 'Grafica';
    public $code;
    public $level;
    public $status;
    public $min_students = 5;
    public $max_students = 10;
    public $duration_hours = 200;
    public $description = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore neque iste tempora, dolorem optio modi unde doloribus rerum";
    public $start_date;
    public $end_date;
    public $center = 'sdasdfsadf';
    public $price = 300;
    public $certification = true;
    public $subjects_selected = [];

    public function mount()
    {
        $this->generateUniqueCode();
    }

    protected function rules()
    {
        $rules = [
            'code' => 'unique:courses',
            'name' => 'required',
            'min_students' => ['nullable'],
            'max_students' => ['nullable'],
            'status' => ['required'],
            'level' => ['required'],
            'duration_hours' => ['required', 'numeric', 'min:200', 'max:900'],
            'description' => ['nullable',  'min:10', 'max:500'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'center' => ['nullable'],
        ];
        return $rules;
    }

    protected $messages = [
        'code.unique' => 'Il codice esiste già',
        'name.required' => 'Il campo è obbligatorio',
        'level.required' => 'Il campo è obbligatorio',
        'duration_hours.required' => 'Il campo è obbligatorio',
        'duration_hours.numeric' => 'Il campo è un numero',
        'duration_hours.min' => 'Il campo deve aver :min',
        'duration_hours.max' => 'Il campo deve aver :max',
        'status.required' => 'Il campo è obbligatorio',
        'description.max' => 'Il campo deve avere :max',
        'start_date.required' => 'Il campo è obbligatorio',
        'start_date.date_format' => 'La data non è nel formato corretto (YYYY-MM-DD)',
        'end_date.required' => 'Il campo è obbligatorio',
        'end_date.date_format' => 'La data non è nel formato corretto (YYYY-MM-DD)',
        'end_date.after' => 'La data di fine deve essere successiva alla data di inizio',
    ];

    private function generateUniqueCode()
    {
        $exists = true;
        $code = "";

        while ($exists) {
            // Genera un codice alfanumerico casuale di 8 caratteri
            $randomPart = strtoupper(bin2hex(random_bytes(4)));
            $code = "#-" . $randomPart;

            // Verifica se esiste già nel database
            $exists = Course::where('code', $code)->exists();
        }

        return $code;
    }


    public function submit()
    {
        $this->validate();

        $course = Course::create([
            'code' => $this->generateUniqueCode(),
            'name' => $this->name,
            'description' => $this->description,
            'level' => $this->level,
            'duration_hours' => $this->duration_hours,
            'min_students' => $this->min_students,
            'max_students' => $this->max_students,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'center' => $this->center,
            'price' => $this->price,
            'certification' => $this->certification,
            /*  'depliant_file' => $this->depliant_file, */
        ]);

        // Sincronizza le materie con la relazione many-to-many
        $course->subjects()->attach($this->subjects_selected);

        return $this->redirect('/tutti-corsi', navigate: true);
    }



    public function render()
    {
        $levels_course = config('Core.levels_course');
        $status_course = config('Core.status_course');
        $subjects = Subject::all();
        return view('livewire.admin.courses.courses-create', compact('levels_course', 'status_course', 'subjects'));
    }
}
