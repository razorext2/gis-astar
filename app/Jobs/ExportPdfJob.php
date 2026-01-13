<?php

namespace App\Jobs;

use App\Events\BasicMakePdfCompletedEvent;
use App\Helpers\ErrorLogger;
use App\Models\User;
use App\Notifications\BaseFileDownload;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class ExportPdfJob implements ShouldQueue
{
    use Queueable;

    protected int $user_id;

    protected string $data_model;

    protected string $data_id;

    protected string $paper_type;

    protected string $paper_orientation;

    protected string $view_template;

    protected string $message;

    protected string $route;

    /**
     * Create a new job instance.
     */
    public function __construct(int $user_id, string $data_model, string $data_id, string $paper_type, string $paper_orientation, string $view_template, string $message, string $route)
    {
        $this->user_id = $user_id;
        $this->data_model = $data_model;
        $this->data_id = $data_id;
        $this->paper_type = $paper_type;
        $this->paper_orientation = $paper_orientation;
        $this->view_template = $view_template;
        $this->message = $message;
        $this->route = $route;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data_model::find($this->data_id);

        $user = User::find($this->user_id);

        try {
            // buat pdf
            $pdf = Pdf::loadView($this->view_template, [
                'data' => $data,
            ]);

            // options nya
            $pdf->setPaper($this->paper_type, $this->paper_orientation);

            // simpan kemari
            $pdf->save($this->data_id.'.pdf', 'pdf');

            // berikan notifikasi ke user yang memiliki permission spk-create
            $user->notify(new BaseFileDownload(
                route: $this->route,
                parameters: [$this->data_id],
                message: $this->message,
                label: 'Download PDF'
            ));

            // ambil id notifikasi terakhir
            $latest_notification_id = $user->notifications()->latest()->first()->id;

            // broadcast pesan
            broadcast(new BasicMakePdfCompletedEvent(
                notification_id: $latest_notification_id,
                user_id: $user->id,
                message: $this->message,
                route: 'spk.download',
                parameters: [$this->data_id],
                label: 'Download PDF',
            ));
        } catch (Throwable $e) {
            ErrorLogger::log($e, 'Gagal menjalankan ExportPdfJob', [
                'model' => $this->data_model,
                'id' => $this->data_id,
            ]);
        }
    }
}
