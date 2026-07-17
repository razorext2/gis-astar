<?php

/** Goal: Mengalihkan kepemilikan SPK dari satu user ke user lain secara asinkron, Caller: User\Edit Livewire, Deps: SpkMain, User */

namespace App\Jobs;

use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TransferSpkOwnershipJob implements ShouldQueue
{
    use Queueable;

    /** @var int Jumlah retry jika job gagal */
    public int $tries = 3;

    /** @var int Timeout per attempt dalam detik */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly int $fromUserId,
        public readonly int $toUserId,
        public readonly int $actedByUserId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fromUser = User::find($this->fromUserId);
        $toUser   = User::find($this->toUserId);

        if (! $fromUser || ! $toUser) {
            return;
        }

        SpkMain::query()
            ->where('added_by', $this->fromUserId)
            ->each(function (SpkMain $spk) use ($fromUser, $toUser) {
                $spk->update([
                    'added_by'         => $toUser->id,
                    'transferred_from' => $fromUser->id,
                    'transferred_to'   => $toUser->id,
                    'transferred_at'   => now(),
                ]);

                $spk->addHistory(
                    'SPK dialihkan.',
                    "SPK ini dialihkan dari {$fromUser->name} ke {$toUser->name} karena akun {$fromUser->name} dinonaktifkan.",
                    $this->actedByUserId
                );
            });
    }
}
