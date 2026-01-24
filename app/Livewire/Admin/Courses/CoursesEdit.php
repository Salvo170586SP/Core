<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithFileUploads;

 
class CoursesEdit extends Component
{
    use WithFileUploads;

    public $id;
    public Course $course;
    public $name;
    public $level;
    public $status;
    public $min_students;
    public $max_students;
    public $duration_hours;
    public $description;
    public $start_date;
    public $end_date;
    public $center;
    public $price;
    public $certification;
    public $subjects_selected = [];


    protected function rules()
    {
        $rules = [
            'name' => 'required',
            'min_students' => ['nullable'],
            'max_students' => ['nullable'],
            'status' => ['required'],
            'level' => ['required'],
            'duration_hours' => ['required', 'numeric', 'min:200', 'max:900'],
            'description' => ['nullable',  'min:10', 'max:500'],
            'start_date' => ['required', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', function ($attribute, $value, $fail) {
                if ($this->start_date && $value <= $this->start_date) {
                    $fail('La data di fine deve essere successiva alla data di inizio');
                }
            }],
            'center' => ['nullable'],
        ];
        return $rules;
    }

    protected $messages = [
        'name.required' => 'Il campo è obbligatorio',
        'duration_hours.required' => 'Il campo è obbligatorio',
        'duration_hours.numeric' => 'Il campo è un numero',
        'duration_hours.min' => 'Il campo deve aver :min',
        'duration_hours.max' => 'Il campo deve aver :max',
        'status.required' => 'Il campo è obbligatorio',
        'level.required' => 'Il campo è obbligatorio',
        'description.min' => 'Il campo deve avere :min',
        'description.max' => 'Il campo deve avere :max',
        'start_date.required' => 'Il campo è obbligatorio',
        'start_date.date_format' => 'La data non è nel formato corretto (YYYY-MM-DD)',
        'end_date.required' => 'Il campo è obbligatorio',
        'end_date.date_format' => 'La data non è nel formato corretto (YYYY-MM-DD)',
        'end_date.after' => 'La data di fine deve essere successiva alla data di inizio',
    ];

    public function mount()
    {
        $this->course = Course::findOrFail($this->id);
        $this->name = $this->course->name;
        $this->level = $this->course->level;
        $this->status = $this->course->status;
        $this->min_students = $this->course->min_students;
        $this->max_students = $this->course->max_students;
        $this->duration_hours = $this->course->duration_hours;
        $this->description = $this->course->description;
        $this->start_date = $this->course->start_date?->format('Y-m-d');
        $this->end_date = $this->course->end_date?->format('Y-m-d');
        $this->center = $this->course->center;
        $this->price = $this->course->price;
        $this->certification = $this->course->certification;
        $this->subjects_selected = $this->course->subjects()->pluck('subjects.id')->toArray();
    }

    public function getLevelLabel($levelId)
    {
        $levels = config('Core.levels', []);
        $level = collect($levels)->firstWhere('id', $levelId);
        return $level['label'] ?? '-';
    }

    public function submit()
    {
        $this->validate();

        $this->course->update([
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
        ]);

        // Sincronizza le materie con la relazione many-to-many
        $this->course->subjects()->sync($this->subjects_selected);

        return $this->redirect('/tutti-corsi', navigate: true);
    }


    public function render()
    {
        $levels_course = config('Core.levels_course');
        $status_course = config('Core.status_course');
        $subjects = Subject::all();

        return view('livewire.admin.courses.courses-edit', compact('levels_course', 'status_course', 'subjects'));
    }
}
