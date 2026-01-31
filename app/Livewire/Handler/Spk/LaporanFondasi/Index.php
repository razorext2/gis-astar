<?php

namespace App\Livewire\Handler\Spk\LaporanFondasi;

use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\LaporanFondasi;
use App\Models\Spk\LaporanFondasi as LaporanFondasiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use HandlesErrors, WithFileUploads;

    public LaporanFondasi $form;

    public ?string $id_spk;

    public ?bool $showLaporanFondasi = false;

    public ?bool $showModalAddLaporanFondasi = false;

    public ?bool $showModalDeleteLaporanFondasi = false;

    public ?string $deleteId = null;

    public ?string $editId = null;

    public bool $isEditing = false;

    public ?array $newDocumentations = [];

    public function mount($id_spk)
    {
        $this->id_spk = $id_spk;
    }

    public function storeLaporanFondasi()
    {
        // cek authorization
        $this->authorize('create', LaporanFondasiModel::class);

        // validasi form
        $this->form->validate();

        $this->runSafely(function () {
            DB::transaction(function () {
                // tambah laporan ke database
                $data = LaporanFondasiModel::create([
                    'id_spk' => $this->id_spk,
                    'judul' => $this->form->title,
                    'status_pengerjaan' => $this->form->progress,
                    'keterangan' => $this->form->description,
                    'added_by' => auth()->user()->id,
                ]);

                // inisialisasi manager
                $manager = new ImageManager(new Driver);

                // upload file
                if ($this->form->documentations) {
                    // inisialisasi array
                    $documents = [];

                    // loop dokumentasi
                    foreach ($this->form->documentations as $documentation) {
                        // set nama file
                        $imageName = Str::uuid().'.jpg';

                        // set path
                        $path = 'laporanfondasi/'.$imageName;

                        // ambil data gambar
                        $image = $manager->read($documentation->getRealPath());

                        // resize gambar maksimal 1024px
                        $image->scaleDown(1024);

                        // convert ke jpg dengan kualitas 70%
                        $imageData = (string) $image->toJpeg(70);

                        // simpan gambar
                        Storage::disk('public')->put($path, $imageData);

                        // assign gambar ke array
                        $documents[] = [
                            'nama_file' => $imageName,
                            'path_file' => $path,
                        ];
                    }

                    // update field dokumentasi
                    $data->update([
                        'dokumentasi' => $documents,
                    ]);
                }
            });

            // reset form
            $this->resetFormState();

            // tutup modal
            $this->showModalAddLaporanFondasi = false;

            // munculkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil membuat Laporan Fondasi baru.');
        }, 'Gagal menyimpan data laporan fondasi', [
            'form_input' => $this->form->all(),
            'user_id' => auth()->user()->id,
        ]);

    }

    public function editLaporanFondasi($id)
    {
        // cek authorization
        $this->authorize('update', LaporanFondasiModel::class);

        // ambil data
        $laporan = LaporanFondasiModel::findOrFail($id);

        // assign form
        $this->form->title = $laporan->judul;
        $this->form->progress = $laporan->status_pengerjaan;
        $this->form->description = $laporan->keterangan;
        $this->editId = $id;
        $this->isEditing = true;
        $this->showModalAddLaporanFondasi = true;
    }

    public function deleteLaporanFondasi($id)
    {
        // aktifkan modal
        $this->showModalDeleteLaporanFondasi = true;

        // assign $id
        $this->deleteId = $id;
    }

    public function deleteLaporanFondasiAction()
    {
        return $this->runSafely(function () {
            // cek authorization
            $this->authorize('delete', LaporanFondasiModel::class);

            // cek ada gak datanya
            $data = LaporanFondasiModel::findOrFail($this->deleteId);

            // hapus file
            foreach ($data->dokumentasi as $row) {
                if (Storage::disk('public')->exists($row['path_file'])) {
                    Storage::disk('public')->delete($row['path_file']);
                }
            }

            // hapus data
            $data->delete();

            // tutup modal
            $this->showModalDeleteLaporanFondasi = false;

            // reset $deleteId
            $this->deleteId = null;

            // munculkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil menghapus Laporan Fondasi.');
        }, 'Gagal menghapus data laporan fondasi', [
            'form_input' => $this->deleteId,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function updateLaporanFondasi()
    {
        // cek authorization
        $this->authorize('update', LaporanFondasiModel::class);

        // validasi field
        $this->form->validateOnly('title');
        $this->form->validateOnly('progress');
        $this->form->validateOnly('description');

        return $this->runSafely(function () {
            // cari data berdasarkan editId
            $data = LaporanFondasiModel::findOrFail($this->editId);

            DB::transaction(function () use ($data) {
                // update data laporan fondasi
                $data->update([
                    'judul' => $this->form->title,
                    'status_pengerjaan' => $this->form->progress,
                    'keterangan' => $this->form->description,
                ]);
            });

            // reset form
            $this->resetFormState();

            // tutup modal
            $this->showModalAddLaporanFondasi = false;

            // tampilkan pesan sukses
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil memperbarui Laporan Fondasi.');
        }, 'Gagal memperbarui data laporan fondasi', [
            'form_input' => $this->form->all(),
            'user_id' => auth()->user()->id,
            'laporan_fondasi_id' => $this->editId,
        ]);
    }

    public function removeDocumentation($index)
    {
        // jika dokumentasi ada
        if (isset($this->form->documentations[$index])) {
            // hapus array dokumentasi
            unset($this->form->documentations[$index]);

            // refresh value array
            $this->form->documentations = array_values($this->form->documentations);
        }
    }

    public function updatedFormNewDocumentations()
    {
        // validasi field newDocumentations
        $this->validateOnly('form.newDocumentations.*');

        // merge array dokumentasi lama dan yang baru
        $this->form->documentations = array_values(array_merge(
            $this->form->documentations ?? [],
            $this->form->newDocumentations ?? [])
        );

        // reset newDocumentations
        $this->form->newDocumentations = [];
    }

    protected function resetFormState(): void
    {
        // set semuanya jadi null
        $this->form->title = null;
        $this->form->progress = null;
        $this->form->description = null;
        $this->form->documentations = [];
        $this->editId = null;
        $this->isEditing = false;
    }

    public function openCreateLaporanFondasiModal(): void
    {
        // reset form
        $this->resetFormState();

        // tampilkan modal
        $this->showModalAddLaporanFondasi = true;
    }

    public function closeLaporanFondasiModal(): void
    {
        // reset form
        $this->resetFormState();

        // tutup modal
        $this->showModalAddLaporanFondasi = false;
    }

    public function render()
    {
        $data = LaporanFondasiModel::where('id_spk', $this->id_spk)
            ->latest()
            ->paginate(5, pageName: 'fondasi-page');

        return view('livewire.handler.spk.laporan-fondasi.index',
            [
                'laporanFondasi' => $data,
                'laporanFondasiLastProgress' => [
                    'value' => $lastLaporanFondasi?->status_pengerjaan ?? 0,
                    'description' => $lastLaporanFondasi?->status_pengerjaan_description ?? 'Belum ada progres.',
                ],
            ]);
    }
}
