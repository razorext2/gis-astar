<?php

namespace App\Livewire\Handler\ProductionHistories;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Spk\ProductionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

    public ?string $id_produksi;

    public ?int $status_produksi;

    public ?string $title = null;

    public ?string $keterangan = null;

    public ?array $documentations = [];

    public ?array $newDocumentations = [];

    public ?int $status_baru = null;

    public ?string $history_id = null;

    public $history_data = null;

    protected function rules(): array
    {
        $baseRules = [
            'title' => 'required|string|min:5|max:100',
            'status_produksi' => 'required',
            'status_baru' => 'nullable|integer|max:10',
            'keterangan' => 'required|string|min:10',
            'newDocumentations.*' => 'image|mimes:jpg,jpeg,png,heic,bmp|max:10240', // 10MB Max
        ];

        // create: documentations adalah file upload
        if (! $this->history_id) {
            return $baseRules + [
                'documentations' => 'required|array|min:1',
                'documentations.*' => 'required|image|mimes:jpg,jpeg,png,heic,bmp|max:10240', // 10MB Max
            ];
        }

        // edit: documentations adalah array dari DB (bukan file)
        return $baseRules + [
            'documentations' => 'nullable|array',
        ];
    }

    protected $messages = [
        'title.required' => 'Judul tidak boleh kosong.',
        'title.min' => 'Judul minimal 5 karakter.',
        'title.max' => 'Judul maksimal 100 karakter.',
        'documentations.required' => 'Gambar tidak boleh kosong.',
        'documentations.*.required' => 'Gambar tidak boleh kosong.',
        'documentations.*.max' => 'Gambar maksimal 10MB.',
        'newDocumentations.*.max' => 'Gambar maksimal 10MB.',
        'status_produksi.required' => 'Status tidak boleh kosong.',
        'status_produksi.min' => 'Status minimal 1 karakter.',
        'status_produksi.max' => 'Status maksimal 50 karakter.',
        'status_baru.max' => 'Status maksimal bernilai 10.',
        'status_baru.integer' => 'Status harus berupa angka.',
        'keterangan.required' => 'Keterangan tidak boleh kosong.',
        'keterangan.min' => 'Keterangan minimal 10 karakter.',
    ];

    public function mount($id_produksi, $status_produksi)
    {
        $this->id_produksi = $id_produksi;
        $this->status_produksi = (int) $status_produksi;

        if (Request::get('history_id')) {
            $this->history_id = Request::get('history_id');

            $this->history_data = ProductionHistory::findOrFail($this->history_id);

            $this->title = $this->history_data->judul;
            $this->status_produksi = $this->history_data->status_produksi;
            $this->keterangan = $this->history_data->keterangan;
            $this->documentations = $this->history_data->documentations;
        }
    }

    public function store()
    {
        $isEdit = (bool) $this->history_id;

        if ($isEdit) {
            $this->authorize('update', ProductionHistory::class);
        } else {
            $this->authorize('create', ProductionHistory::class);
        }

        // validasi data
        $this->validate();

        // proses simpan
        $this->runSafely(function () use ($isEdit) {
            // gaskan
            DB::transaction(function () use ($isEdit) {
                if ($isEdit) {
                    $history = ProductionHistory::findOrFail($this->history_id);

                    $history->update([
                        'judul' => $this->title,
                        'keterangan' => $this->keterangan,
                        'status_produksi' => $this->status_baru ? $this->status_baru : $this->status_produksi,
                        'documentations' => array_values(array_filter($this->documentations ?? [], 'is_array')),
                        'updated_by' => Auth::id(),
                    ]);
                } else {
                    // tambah data history baru
                    $history = ProductionHistory::create([
                        'id_produksi' => $this->id_produksi,
                        'judul' => $this->title,
                        'keterangan' => $this->keterangan,
                        'status_produksi' => $this->status_baru ? $this->status_baru : $this->status_produksi,
                        'status_validasi' => 0,
                        'added_by' => Auth::id(),
                    ]);

                    // jika dokumentasi ada (create mode, isinya file upload)
                    if ($this->documentations) {
                        $paths = [];

                        foreach ($this->documentations as $image) {
                            $paths[] = $this->storeDocumentationImage($image);
                        }

                        $history->update([
                            'documentations' => $paths,
                        ]);
                    }
                }
            });

            // reset form
            $this->reset();

            // munculkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil',
                text: $isEdit ? 'Berhasil mengubah riwayat produksi.' : 'Berhasil menyimpan riwayat produksi.',
                redirect: [
                    'url' => route('production.index'),
                    'delay' => 2000,
                ]
            );

        }, 'Gagal menyimpan data production history.', [
            'form_input' => [
                'id_produksi' => $this->id_produksi,
                'status_produksi' => $this->status_produksi,
                'title' => $this->title,
            ],
            'user_id' => Auth::id(),
        ]);
    }

    public function removeDocumentation($index)
    {
        // jika dokumentasi ada
        if (isset($this->documentations[$index])) {
            // ambil data dokumentasi
            $removedDocumentation = $this->documentations[$index];

            // hapus data dokumentasi dalam array
            unset($this->documentations[$index]);

            // update dan urutkan array terbaru
            $this->documentations = array_values($this->documentations);

            // jika ada history_id
            if ($this->history_id) {
                $this->authorize('update', ProductionHistory::class);

                $this->runSafely(function () use ($removedDocumentation) {
                    $history = ProductionHistory::findOrFail($this->history_id);

                    $pathFile = is_array($removedDocumentation) ? ($removedDocumentation['path_file'] ?? null) : null;
                    $fileExisted = $pathFile ? Storage::disk('public')->exists($pathFile) : false;

                    if ($pathFile) {
                        Storage::disk('public')->delete($pathFile);
                    }

                    $documentationsForDb = array_values(array_filter($this->documentations ?? [], 'is_array'));

                    $history->update([
                        'documentations' => $documentationsForDb,
                        'updated_by' => Auth::id(),
                    ]);

                    $this->documentations = $documentationsForDb;

                    $this->dispatch(
                        event: 'swal',
                        icon: 'success',
                        title: 'Berhasil',
                        text: $fileExisted ? 'Dokumentasi berhasil dihapus.' : 'Dokumentasi dihapus (file tidak ditemukan).'
                    );
                }, 'Gagal menghapus dokumentasi.', [
                    'history_id' => $this->history_id,
                    'index' => $index,
                    'user_id' => Auth::id(),
                ]);
            }
        }
    }

    public function updatedNewDocumentations()
    {
        // validasi gambar baru
        $this->validateOnly('newDocumentations.*');

        // edit mode: upload & sync ke DB agar $documentations tidak berisi file object
        if ($this->history_id) {
            $this->authorize('update', ProductionHistory::class);

            $this->runSafely(function () {
                $history = ProductionHistory::findOrFail($this->history_id);

                $existing = array_values(array_filter($this->documentations ?? [], 'is_array'));
                $added = [];

                foreach (($this->newDocumentations ?? []) as $image) {
                    $added[] = $this->storeDocumentationImage($image);
                }

                $merged = array_values(array_merge($existing, $added));

                $history->update([
                    'documentations' => $merged,
                    'updated_by' => Auth::id(),
                ]);

                $this->documentations = $merged;
            }, 'Gagal menambahkan dokumentasi.', [
                'history_id' => $this->history_id,
                'user_id' => Auth::id(),
            ]);

            $this->newDocumentations = [];

            return;
        }

        // create mode: merge file uploads ke array documentations (untuk diproses saat store)
        $this->documentations = array_values(array_merge(
            $this->documentations ?? [],
            $this->newDocumentations ?? []
        ));

        // kosongkan gambar baru
        $this->newDocumentations = [];
    }

    private function storeDocumentationImage($image): array
    {
        $manager = new ImageManager(new Driver);

        $imageName = Str::uuid().'.jpg';
        $path = 'production-histories/'.$imageName;

        $image = $manager->read($image->getRealPath());
        $image->scaleDown(1024);

        $imagedata = (string) $image->toJpeg(80);

        Storage::disk('public')->put($path, $imagedata);

        return [
            'nama_file' => $imageName,
            'path_file' => $path,
        ];
    }

    public function render()
    {
        $statuses = [
            ['value' => 0, 'label' => 'SPK Dibuat'],
            ['value' => 1, 'label' => 'Pengadaan Material'],
            ['value' => 2, 'label' => 'Penandaan & Pemotognan'],
            ['value' => 3, 'label' => 'Penyetelan'],
            ['value' => 4, 'label' => 'Pengelasan'],
            ['value' => 5, 'label' => 'Pengeboran & Tapping'],
            ['value' => 6, 'label' => 'Perakitan & Pengujian'],
            ['value' => 7, 'label' => 'Prosedur NDT'],
            ['value' => 8, 'label' => 'Sandblasting'],
            ['value' => 9, 'label' => 'Pengecatan'],
            ['value' => 10, 'label' => 'Selesai'],
        ];

        return view('livewire.handler.production-histories.create',
            ['statuses' => $statuses]);
    }
}
