<?php

namespace App\Livewire\Handler\Question;

use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public string $for;
    public int $is_active;
    public string $question;
    public int $optionCount = 1;
    public array $options = [0 => null];

    public function addOption()
    {
        $this->options[] = null;
    }

    public function removeOption($index)
    {
        if (count($this->options) > 1) {
            unset($this->options[$index]);
            $this->options = array_values($this->options);
        }
    }

    public function store()
    {
        try {
            DB::beginTransaction();

            $question = Question::create([
                'for' => $this->for,
                'is_active' => $this->is_active,
                'question' => $this->question,
                'added_by' => \Illuminate\Support\Facades\Auth::id(),
            ]);

            foreach ($this->options as $option) {
                $option = QuestionOption::create([
                    'id_question' => $question->id,
                    'option' => $option,
                ]);
            }

            DB::commit();
            $this->reset();
            return $this->dispatch('swal', title: 'Berhasil', text: 'Pertanyaan berhasil ditambahkan', icon: 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->reset();
            return $this->dispatch('swal', title: 'Gagal', text: $e->getMessage(), icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.handler.question.create');
    }
}
