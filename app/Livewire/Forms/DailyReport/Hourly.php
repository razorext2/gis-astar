<?php

namespace App\Livewire\Forms\DailyReport;

use Livewire\Form;

class Hourly extends Form
{
    public $start_time;

    public $end_time;

    public ?string $activity = '';

    public ?string $notes = '';

    public function rules()
    {
        return [
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'activity' => 'required|string|min:5|max:100',
            'notes' => 'required|string|min:5',
        ];
    }
}
