<?php

namespace App\Livewire\Handler\Spk;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Billing;
use App\Models\Spk\ReceivableHistory;
use App\Models\Spk\SpkMain;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BillingUpdate extends Component
{
    use HandlesErrors;

    public Billing $form;

    public $spk_data;

    public function mount($id): void
    {
        $this->spk_data = SpkMain::with('invoice', 'receivableHistories')
            ->findOrFail($id);

        $this->form->nomor_tagihan = $this->spk_data->nomor_tagihan;
        $this->form->status_nomor_tagihan = $this->spk_data->status_nomor_tagihan;
        $this->form->tipe_tagihan = $this->spk_data->tipe_tagihan;
    }

    public function search(): void
    {
        $this->form->validate();

        $tipeTagihan = config('spk-config.spk_tipe_tagihan')[$this->form->tipe_tagihan];

        try {
            // Call API utama
            $mainData = $this->form->fetchApi(
                $tipeTagihan['api'],
                $this->form->nomor_tagihan
            );

            // Call API sisa
            $sisaData = $this->form->fetchApi(
                $tipeTagihan['api_sisa'],
                $this->form->nomor_tagihan
            );

            // Merge data setelah keduanya valid
            $data = array_merge($mainData, $sisaData);

            // Set state
            $this->form->nama_customer = $data['NamaCustomer'] ?? null;
            $this->form->nomor_tagihan_baru = $data['NomorPermintaanJual'] ?? null;
            $this->form->total_tagihan = (float) ($data['JumlahPiutang'] ?? 0);
            $this->form->total_bayar = (float) ($data['TotalBayar'] ?? 0);
            $this->form->sisa = (float) ($data['SisaPiutang'] ?? 0);

        } catch (\Throwable $e) {
            $this->dispatch(
                event: 'swal',
                icon: 'error',
                title: 'Gagal',
                text: $e->getMessage()
            );

            return;
        }
    }

    public function assign(): void
    {
        $customer_from_db = (string) $this->form->sanitizeAlphaNumeric($this->spk_data->customer['nama_perusahaan']);
        $customer_from_api = (string) $this->form->sanitizeAlphaNumeric($this->form->nama_customer);

        $policy = match ($this->form->tipe_tagihan) {
            'idcnon' => 'updateNoTagihanIdcNonPpn',
            'idcppn' => 'updateNoTagihanIdcPpn',
            'idyppn' => 'updateNoTagihanIdyPpn',
        };

        // check authorization
        $this->authorize($policy, SpkMain::class);

        // check kesamaan data customer
        if ($customer_from_db !== $customer_from_api) {
            $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Data customer tidak sama.');

            return;
        }

        $this->runSafely(function () {
            DB::transaction(function () {
                // update nomor tagihan di spk
                $spk = $this->spk_data->update([
                    'tipe_tagihan' => $this->form->tipe_tagihan,
                    'nomor_tagihan' => $this->form->nomor_tagihan_baru,
                    'status_nomor_tagihan' => 1, // sudah diassign
                    'status' => 4, // penagihan
                    'updated_by' => Auth::id(),
                    'no_tagihan_updated_by' => Auth::id(),
                ]);

                if (! $spk) {
                    throw new \Exception('Gagal update nomor tagihan di SPK.');
                }

                // update history
                $history = ReceivableHistory::create([
                    'spk_id' => $this->spk_data->id,
                    'nomor_sr' => $this->spk_data->nomor_tagihan,
                    'total_piutang' => $this->form->total_tagihan,
                    'sisa_piutang_sebelum' => $this->spk_data->receivableHistories()->latest()?->sisa_piutang_sesudah ?? 0,
                    'sisa_piutang_sesudah' => $this->form->sisa,
                    'selisih' => $this->form->total_tagihan - $this->form->sisa,
                    'source' => 'manual',
                    'updated_by' => Auth::id(),
                    'checked_at' => now(),
                ]);

                if (! $history) {
                    throw new \Exception('Gagal update history penagihan.');
                }

                $this->spk_data->addHistory(
                    'Nomor SR penagihan di-assign.',
                    Auth::user()->name.' telah meng-assign nomor SR penagihan ('.$this->form->nomor_tagihan_baru.').',
                    Auth::id()
                );
            });

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
            'form' => [
                'id_spk' => $this->spk_data->id,
                'nomor_tagihan' => $this->form->nomor_tagihan_baru,
            ],
            'user_id' => Auth::id(),
        ]);
    }

    #[Computed]
    public function histories()
    {
        if (is_null($this->spk_data->nomor_tagihan)) {
            return [];
        }

        return $this->spk_data->receivableHistories()
            ->orderBy('created_at', 'asc')
            ->paginate(10, pageName: 'receivable-histories-page');
    }

    public function render(): View
    {
        return view('livewire.handler.spk.billing-update');
    }
}
