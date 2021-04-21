<?php

namespace App\Http\Livewire;

use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Manny;

class WorkScheduleForm extends Component
{
    use AuthorizesRequests;

    public $workSchedule;
    public $confirmingDelete = false;

    public $state = [
        'weekday' => 0,
    ];

    public function saveWorkSchedule()
    {
        Validator::make($this->state, [
            'weekday' => ['required', 'min:0', 'max:6'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i', 'after:start'],
        ], [
            'start.date_format' => __('Invalid Field'),
        ])->validate();

        if (!$this->workSchedule) {
            $this->authorize('workSchedule:create');
            $this->workSchedule = WorkSchedule::create($this->state);
        } else {
            $this->authorize('workSchedule:update');
            $this->workSchedule->update($this->state);
        }

        return redirect()->route("workSchedule.index");
    }

    public function delete()
    {
        $this->authorize('workSchedule:delete');
        $this->workSchedule->delete();
        return redirect()->route("workSchedule.index");
    }

    public function validateTime($field)
    {
        $this->state[$field] = Manny::mask($this->state[$field], '11:11');
        if (strlen($this->state[$field]) == 5) {
            $this->state[$field] = Carbon::createFromFormat("H:i", $this->state[$field])->format("H:i");
        }
    }

    public function updated($field)
    {
        if ($field == "state.start") {
            $this->validateTime('start');
        }

        if ($field == "state.end") {
            $this->validateTime('end');
            if ($this->state["end"] == "00:00") {
                $this->state["end"] = "23:59";
            }
        }
    }

    public function mount()
    {
        if ($this->workSchedule) {
            $this->state = [
                'weekday' => $this->workSchedule->getRawOriginal('weekday'),
                'start' => $this->workSchedule->start,
                'end' => $this->workSchedule->end,
            ];
        }
    }

    public function render()
    {
        return view('work_schedule.work-schedule-form');
    }
}
