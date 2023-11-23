<?php

namespace App\Http\Livewire;

use App\Models\Exercise;
use Livewire\Component;
use Livewire\WithPagination;

class ExerciseTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rows_pagination = 10;
    public $sort = "ASC"; #DESC

    public function getExercise()
    {
        return Exercise::query()->with('level', 'equipment', 'muscle')->orderBy('id', $this->sort)->paginate($this->rows_pagination);
    }

    public function render()
    {
        $exercises = $this->getExercise();
        return view('livewire.exercise-table', [
            "exercises" => $exercises
        ]);
    }
}
