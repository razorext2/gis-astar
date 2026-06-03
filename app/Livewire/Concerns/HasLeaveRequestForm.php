<?php

/** Goal: Shared methods for Leave Request form components (Create & Borrow), Caller: Create.php, Borrow.php, Deps: Carbon */

namespace App\Livewire\Concerns;

trait HasLeaveRequestForm
{
    public function selectBackupPerson($id, $name): void
    {
        $this->backup_person_id = $id;
        $this->search_backup = $name;
    }

    public function showOnLeaveError($name): void
    {
        $this->dispatch('swal', icon: 'error', title: 'Tidak Dapat Dipilih', text: "{$name} saat ini sedang dalam masa cuti dan tidak dapat dijadikan personel backup.");
    }

    public function removeAttachment($index): void
    {
        if (isset($this->attachments[$index])) {
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    protected function checkDateOverlap(): void
    {
        $this->dateOverlapError = null;

        if (! $this->start_date || ! $this->end_date) {
            return;
        }

        if (\Carbon\Carbon::parse($this->start_date)->greaterThan(\Carbon\Carbon::parse($this->end_date))) {
            $this->dateOverlapError = 'Tanggal mulai tidak boleh lebih besar dari tanggal berakhir.';

            return;
        }

        $overlap = auth()->user()->leaveRequests()
            ->whereNotIn('status', ['rejected', 'auto_reject', 'canceled'])
            ->where(function ($query) {
                $query->where('start_date', '<=', $this->end_date)
                    ->where('end_date', '>=', $this->start_date);
            })
            ->first();

        if ($overlap) {
            $from = \Carbon\Carbon::parse($overlap->start_date)->locale('id')->isoFormat('D MMM YYYY');
            $to = \Carbon\Carbon::parse($overlap->end_date)->locale('id')->isoFormat('D MMM YYYY');
            $this->dateOverlapError = "Tanggal bertabrakan dengan pengajuan cuti yang sudah ada ({$from} s/d {$to}).";
        }
    }
}
