<?php

namespace App\Livewire\Admin\EveningCourses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class EveningCoursesIndex extends Component
{
    use WithPagination;

    public $selected = [];
    public $selectAll = false;

    public function updatedSelected()
    {
        $totalCourses = Course::where('type', 'evening')->count();
        $this->selectAll = count($this->selected) === $totalCourses && $totalCourses > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Course::where('type', 'evening')->pluck('id')->toArray();
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

        Course::where('type', 'evening')->whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            Course::where('type', 'evening')->findOrFail($item_id)->delete();
        }

        $this->selected = [];
    }
    
    public function render()
    {
        $evening_courses = Course::where('type', 'evening')->with('subjects')->latest()->paginate(10);
        return view('livewire.admin.evening-courses.evening-courses-index', compact('evening_courses'));
    }
}
