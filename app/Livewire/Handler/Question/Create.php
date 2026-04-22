<?php

namespace App\Livewire\Handler\Question;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

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
        return $this->runSafely(function () {
            DB::transaction(function () {
                $question = Question::create([
                    'for' => $this->for,
                    'is_active' => $this->is_active,
                    'question' => $this->question,
                    'added_by' => \Illuminate\Support\Facades\Auth::id(),
                ]);

                foreach ($this->options as $option) {
                    QuestionOption::create([
                        'id_question' => $question->id,
                        'option' => $option,
                    ]);
                }
            });

            $this->reset();

            return $this->dispatch('swal', title: 'Berhasil', text: 'Pertanyaan berhasil ditambahkan', icon: 'success');
        }, 'Gagal menyimpan pertanyaan baru.', [
            'action' => 'create question',
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.handler.question.create');
    }
}
