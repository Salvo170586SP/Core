<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;

class CoursesIndex extends Component
{
    public $selected = [];
    public $selectAll = false;

    public function updatedSelected()
    {
        $totalCourses = Course::count();
        $this->selectAll = count($this->selected) === $totalCourses && $totalCourses > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Course::pluck('id')->toArray();
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
            
        Course::whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            Course::findOrFail($item_id)->delete();
        }

        $this->selected = [];
    }

    public function render()
    {
        $courses = Course::with('subjects')->latest()->get();
        return view('livewire.admin.courses.courses-index', compact('courses'));
    }
}
