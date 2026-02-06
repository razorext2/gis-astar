<?php

namespace App\Livewire\Utils;

use App\Models\Spk\SpkMain;
use Livewire\Component;

class ProgresSpk extends Component
{
    public SpkMain $data;

    public array $status = [
        [
            'status' => 0,
            'desc' => 'SPK telah dibuat',
            'icon' => 'spk-selesai.webp',
        ],
        [
            'status' => 1,
            'desc' => 'Menunggu Assign PR',
            'icon' => 'assign-pr.webp',
        ],
        [
            'status' => 2,
            'desc' => 'Dalam proses produksi',
            'icon' => 'diproduksi.webp',
        ],
        [
            'status' => 3,
            'desc' => 'Dalam proses pengiriman',
            'icon' => 'dikirim.webp',
        ],
        [
            'status' => 4,
            'desc' => 'Dalam proses penagihan',
            'icon' => 'penagihan.webp',
        ],
        [
            'status' => 5,
            'desc' => 'Dalam proses pemasangan',
            'icon' => 'pemasangan.webp',
        ],
        [
            'status' => 6,
            'desc' => 'Selesai',
            'icon' => 'selesai.webp',
        ],
    ];

    public function mount($id)
    {
        $this->data = SpkMain::select(
            'id',
            'on_delay',
            'on_delay_at',
            'on_delay_by',
            'on_delay_notes',
            'status_approval',
            'cancel_request_at',
            'cancel_request_validated_at',
            'cancel_request_reason',
            'cancel_request_by',
            'status'
        )
            ->with([
                'onDelayBy:id,name',
                'cancelRequestBy:id,name',
            ])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.utils.progres-spk');
    }
}
