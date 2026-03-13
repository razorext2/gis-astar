<?php

namespace App\Livewire\Handler\Spk\DailyReport;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\DailyReport\Project as ProjectForm;
use App\Models\Spk\ProjectAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Assign extends Component
{
    use HandlesErrors;

    public ProjectForm $form;

    public ?string $no_vt = '';

    public ?array $partnerData = [];

    public ?array $partner = [];

    public function mount()
    {
        if (request()->has('spk_id')) {
            $this->form->spk_id = request('spk_id');
        }
    }

    public function fetchVT()
    {
        // validasi field
        $this->form->validateOnly('no_vt');

        // ambil data dari fetch api
        $data = $this->runSafely(function () {
            return $this->form->fetch($this->form->no_vt);
        });

        if (empty($data)) { // jika datakosong, tampilkan error
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Data VT tidak ditemukan.');
        }

        // tampilkan berhasil kalo ada data
        $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Data VT ditemukan.');

        // inisialisasi data partner
        $this->partnerData = $data;
    }

    public function store()
    {
        // validasi form
        $this->form->validate();

        // ambil data partner yang dicentang
        $selectedPartner = array_keys(array_filter($this->partner));

        if (empty($selectedPartner)) { // kalo ga ada yg dicentang, tampilkan error
            return $this->dispatch('swal', icon: 'error', title: 'Gagal', text: 'Minimal harus ada 1 teknisi yang di assign.');
        }

        // filter data partner berdasarkan partner yg dipilih
        $dataPartners = collect($this->partnerData)
            ->whereIn('NomorIdentitasTeknisi', $selectedPartner);

        // ambil user berdasarkan partner yg dipilih
        $users = \App\Models\User::whereIn(
            'kode_pegawai',
            $dataPartners->pluck('NomorIdentitasTeknisi')->unique()
        )->get()->keyBy('kode_pegawai');

        // gabungkan dataPartners dan model user
        $dataPartners = $dataPartners
            ->map(function ($partner) use ($users) {
                $partner['user'] = $users[$partner['NomorIdentitasTeknisi']] ?? null;

                return $partner;
            })
            ->filter(fn ($partner) => $partner['user'] !== null)
            ->values();

        // store ke database
        $this->runSafely(function () use ($dataPartners) {
            DB::transaction(function () use ($dataPartners) {
                // store project dulu
                $project = \App\Models\Spk\Project::create([
                    'spk_id' => filled($this->form->spk_id) ? $this->form->spk_id : null,
                    'start_date' => $this->form->start_date,
                    'end_date' => $this->form->end_date,
                    'deadline' => $this->form->end_date,
                    'project_name' => $this->form->project_name,
                    'description' => $this->form->description,
                    'created_by' => auth()->id(),
                ]);

                // mapping dulu data assignment
                $assignments = $dataPartners->map(function ($partner) use ($project) {
                    return [
                        'id' => Str::ulid(),
                        'project_id' => $project->id,
                        'laporan_type' => 'mekanik',
                        'nomor_vt' => $partner['NomorKunjungan'],
                        'assign_to' => $partner['user']->id,
                        'assign_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                })->toArray();

                // assign project ke staff
                ProjectAssignment::insert($assignments);
            });

            // tampilkan berhasil kalo berhasil
            $this->dispatch('swal', icon: 'success', title: 'Berhasil', text: 'Project berhasil dibuat.');

            // redirect
            if ($this->form->spk_id) {
                return $this->redirectRoute('daily-report.assign', ['spk_id' => $this->form->spk_id]);
            } else {
                return $this->redirectRoute('report.general.assign');
            }
        }, 'Gagal membuat project.', [
            'user_id' => auth()->id(),
            'action' => 'create project',
            'spk_id' => $this->form->spk_id,
        ]);
    }

    public function render()
    {
        return view('livewire.handler.spk.daily-report.assign');
    }
}
