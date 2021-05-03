<?php

namespace App\Http\Livewire;

use App\Models\DayOff;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Manny;

class DayOffForm extends Component
{
    use AuthorizesRequests;

    public $dayOff;

    public $state = [];
    public $confirmingDelete = false;

    public function mount()
    {
        if ($this->dayOff) {
            $this->state = [
                'day' => $this->dayOff->day,
                'start' => $this->dayOff->start,
                'end' => $this->dayOff->end,
            ];
        } else {
            $this->state = [
                'day' => Carbon::now()->format('d/m/Y'),
            ];
        }
    }

    public function save()
    {
        Validator::make($this->state, [
            'day' => ['required', 'date_format:d/m/Y'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i', 'after:start'],
        ], [
            'start.date_format' => __('Invalid Field'),
        ])->validate();

        $data = $this->state;
        $data['day'] = Carbon::createFromFormat('d/m/Y', $this->state['day']);

        if (!$this->dayOff) {
            $this->authorize('dayOff:create');
            $this->dayOff = DayOff::create($data);
            session()->flash('flash.banner', __('Day Off successfully created!'));
        } else {
            $this->authorize('dayOff:update');
            $this->dayOff->update($data);
            session()->flash('flash.banner', __('Day Off successfully updated!'));
        }

        return redirect()->route("dayOff.index");
    }

    public function delete()
    {
        $this->authorize('dayOff:delete');
        $this->dayOff->delete();
        session()->flash('flash.banner', __('Day Off successfully deleted!'));
        return redirect()->route("dayOff.index");
    }

    public function updated($field)
    {
        if ($field == "state.day") {
            $this->state['day'] = Manny::mask($this->state['day'], '11/11/1111');
            if (strlen($this->state['day']) == 10) {
                $this->state['day'] = Carbon::createFromFormat("d/m/Y", $this->state['day'])->format("d/m/Y");
            }
        }

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

    public function validateTime($field)
    {
        $this->state[$field] = Manny::mask($this->state[$field], '11:11');
        if (strlen($this->state[$field]) == 5) {
            $this->state[$field] = Carbon::createFromFormat("H:i", $this->state[$field])->format("H:i");
        }
    }

    public function render()
    {
        return view('day_off.day-off-form');
    }
}
