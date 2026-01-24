<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CoursesIndex extends Component
{
    use WithPagination;

    public $selected = [];
    public $selectAll = false;

    public function updatedSelected()
    {
        $totalCourses = Course::where('type', 'all')->count();
        $this->selectAll = count($this->selected) === $totalCourses && $totalCourses > 0;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = Course::where('type', 'all')->pluck('id')->toArray();
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

        Course::where('type', 'all')->whereIn('id', $this->selected)->delete();
        $this->selected = [];
    }

    public function delete($item_id)
    {
        if ($item_id) {
            Course::where('type', 'all')->findOrFail($item_id)->delete();
        }

        $this->selected = [];
    }

    public function render()
    {
        $courses = Course::where('type', 'all')->with('subjects')->latest()->paginate(10);
        return view('livewire.admin.courses.courses-index', compact('courses'));
    }
}
