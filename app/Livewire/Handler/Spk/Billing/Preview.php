<?php

/** Goal: Component for displaying fetched BSI tagihan under subfolder, Caller: update.blade.php, Deps: SpkMain, AssignService, Auth */

namespace App\Livewire\Handler\Spk\Billing;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\SpkMain;
use App\Services\Spk\Billing\AssignService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Preview extends Component
{
    use HandlesErrors;

    public SpkMain $spk_data;

    public ?string $nomor_tagihan = null;
    public ?string $form_tipe_tagihan = null;
    public ?string $nama_customer = null;
    public ?string $customer_contact = null;
    public ?string $nomor_tagihan_baru = null;
    public float $subtotal = 0;
    public float $total = 0;
    public string $jumlah_piutang_field = 'subtotal';
    public float $jumlah_piutang = 0;
    public float $total_bayar = 0;
    public float $sisa = 0;
    public array $sisaItems = [];

    public float $totalSisaDihitung = 0;
    public float $totalSelisih = 0;
    public float $totalDpPaid = 0;

    protected $listeners = [
        'bsi-data-fetched' => 'handleDataFetched',
        'bsi-data-cleared' => 'handleDataCleared',
    ];

    public function mount(SpkMain $spkData): void
    {
        $this->spk_data = $spkData;
    }

    public function handleDataFetched(array $mainData, array $sisaItems, string $tipeTagihan, string $nomorTagihan): void
    {
        $this->nomor_tagihan = $nomorTagihan;
        $this->form_tipe_tagihan = $tipeTagihan;
        $this->nama_customer = $mainData['NamaCustomer'] ?? null;
        $this->customer_contact = $mainData['CustomerContact'] ?? null;
        $this->nomor_tagihan_baru = $mainData['NomorPermintaanJual'] ?? null;
        $this->subtotal = (float) ($mainData['SubTotal'] ?? 0);
        $this->total = (float) ($mainData['Total'] ?? 0);

        $this->jumlah_piutang_field = match ($tipeTagihan) {
            'idyppn' => 'total',
            default => 'subtotal',
        };

        $this->recalculateJumlahPiutang();

        $this->sisaItems = array_map(
            fn (array $item) => array_merge($item, ['is_dp' => false]),
            $sisaItems
        );

        if (empty($this->nama_customer)) {
            $this->nama_customer = $sisaItems[0]['NamaCustomer'] ?? null;
        }

        $this->recalculateSisaTotals();

        $this->dispatch('scroll-to-rekap');
    }

    public function handleDataCleared(): void
    {
        $this->nomor_tagihan = null;
        $this->form_tipe_tagihan = null;
        $this->nomor_tagihan_baru = null;
        $this->nama_customer = null;
        $this->customer_contact = null;
        $this->subtotal = 0;
        $this->total = 0;
        $this->jumlah_piutang_field = 'subtotal';
        $this->jumlah_piutang = 0;
        $this->total_bayar = 0;
        $this->sisa = 0;
        $this->sisaItems = [];
        $this->totalSisaDihitung = 0;
        $this->totalSelisih = 0;
        $this->totalDpPaid = 0;
    }

    public function updated(string $property): void
    {
        if ($property === 'jumlah_piutang_field') {
            $this->recalculateJumlahPiutang();
            $this->recalculateSisaTotals();
        }
    }

    public function toggleSisaItemDp(int $index): void
    {
        // Guard: pastikan data sudah difetch dan index valid
        if (is_null($this->nomor_tagihan_baru) || ! isset($this->sisaItems[$index])) {
            return;
        }

        $this->sisaItems[$index]['is_dp'] = ! ($this->sisaItems[$index]['is_dp'] ?? false);
        $this->recalculateSisaTotals();
    }

    public function assign(): void
    {
        // BP-04: authorize PERTAMA sebelum akses data apapun
        $policy = match ($this->form_tipe_tagihan) {
            'idcnon' => 'updateNoTagihanIdcNonPpn',
            'idcppn' => 'updateNoTagihanIdcPpn',
            'idyppn' => 'updateNoTagihanIdyPpn',
            default => 'updateNoTagihanIdcNonPpn',
        };

        $this->authorize($policy, SpkMain::class);

        $customerFromDb = $this->sanitizeAlphaNumeric($this->spk_data->customer['nama_perusahaan']);
        $customerFromApi = $this->sanitizeAlphaNumeric($this->nama_customer ?? '');

        if ($customerFromDb !== $customerFromApi) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Data customer tidak sama.');
            return;
        }

        $this->runSafely(function () {
            /** @var AssignService $service */
            $service = app(AssignService::class);

            $service->assign(
                spk: $this->spk_data,
                formTipeTagihan: $this->form_tipe_tagihan,
                nomorTagihanBaru: $this->nomor_tagihan_baru,
                subtotal: $this->subtotal,
                total: $this->total,
                jumlahPiutang: $this->jumlah_piutang,
                jumlahPiutangField: $this->jumlah_piutang_field,
                totalSisaDihitung: (int) $this->totalSisaDihitung,
                sisaItems: $this->sisaItems,
            );

            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: 'Nomor tagihan berhasil diassign.',
                redirect: [
                    'url' => route('billing.index'),
                    'delay' => 2500,
                ]
            );
        }, 'Gagal assign nomor tagihan', [
            'form' => ['id_spk' => $this->spk_data->id, 'nomor_tagihan' => $this->nomor_tagihan_baru],
        ]);
    }

    private function sanitizeAlphaNumeric(string $text): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $text));
    }

    private function recalculateJumlahPiutang(): void
    {
        $this->jumlah_piutang = $this->jumlah_piutang_field === 'total'
            ? $this->total
            : $this->subtotal;
    }

    private function recalculateSisaTotals(): void
    {
        $items = collect($this->sisaItems);
        $nonDpItems = $items->where('is_dp', false);
        $dpItems = $items->where('is_dp', true);

        $this->total_bayar = $nonDpItems->sum(fn (array $item) => (float) ($item['TotalBayar'] ?? 0));
        $this->totalDpPaid = $dpItems->sum(fn (array $item) => (float) ($item['TotalBayar'] ?? 0));
        $this->totalSisaDihitung = $this->jumlah_piutang - $this->total_bayar;
        $this->sisa = $this->totalSisaDihitung;

        $nonDpSisa = $nonDpItems->sum(fn (array $item) => (float) ($item['SisaPiutang'] ?? 0));
        $this->totalSelisih = $this->jumlah_piutang - ($this->total_bayar + $nonDpSisa);
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing.preview');
    }
}
