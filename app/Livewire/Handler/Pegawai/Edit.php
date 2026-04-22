<?php

namespace App\Livewire\Handler\Pegawai;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    use HandlesErrors, WithFileUploads;

    public Pegawai $pegawai;

    // Pegawai Fields
    public $kode_pegawai;

    public $nik_pegawai;

    public $full_name;

    public $nick_name;

    public $no_telp;

    public $alamat;

    public $jabatan;

    public $golongan;

    public $tgl_lahir;

    // User Account Fields (Existing User)
    public $has_account = false;

    public $selected_roles = [];

    // Photo Uploads
    public $photo1;

    public $photo2;

    public $existing_images = [];

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
        $this->kode_pegawai = $pegawai->kode_pegawai;
        $this->nik_pegawai = $pegawai->nik_pegawai;
        $this->full_name = $pegawai->full_name;
        $this->nick_name = $pegawai->nick_name;
        $this->no_telp = $pegawai->no_telp;
        $this->alamat = $pegawai->alamat;
        $this->jabatan = $pegawai->jabatan;
        $this->golongan = $pegawai->golongan;
        $this->tgl_lahir = $pegawai->tgl_lahir;

        // Check if user account exists
        $user = User::where('kode_pegawai', $this->kode_pegawai)->first();
        if ($user) {
            $this->has_account = true;
            $this->selected_roles = $user->roles->pluck('name')->toArray();
        }

        // Get existing images
        $this->loadExistingImages();
    }

    public function loadExistingImages()
    {
        $path = public_path('storage/'.$this->pegawai->storage);
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg'])) {
                    $this->existing_images[] = $file;
                }
            }
        }
    }

    protected function rules()
    {
        return [
            'nik_pegawai' => 'required',
            'full_name' => 'required',
            'nick_name' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required|exists:tb_jabatan,id',
            'golongan' => 'required|exists:tb_golongan,id',
            'tgl_lahir' => 'required|date',
            'photo1' => 'nullable|image|max:2048',
            'photo2' => 'nullable|image|max:2048',
            'selected_roles' => 'nullable|array',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->runSafely(function () {
            $this->pegawai->update([
                'nik_pegawai' => $this->nik_pegawai,
                'full_name' => $this->full_name,
                'nick_name' => $this->nick_name,
                'no_telp' => $this->no_telp,
                'alamat' => $this->alamat,
                'jabatan' => $this->jabatan,
                'golongan' => $this->golongan,
                'tgl_lahir' => $this->tgl_lahir,
            ]);

            // Sync Roles if account exists
            if ($this->has_account) {
                $user = User::where('kode_pegawai', $this->kode_pegawai)->first();
                if ($user) {
                    $user->syncRoles($this->selected_roles);
                    $user->update(['name' => $this->full_name]);
                }
            }

            // Handle File Uploads
            if ($this->photo1 || $this->photo2) {
                $folderPath = "public/labels/{$this->kode_pegawai}";
                $folderToDB = "labels/{$this->kode_pegawai}/";

                if (! Storage::exists($folderPath)) {
                    Storage::makeDirectory($folderPath);
                }

                if ($this->photo1) {
                    $this->photo1->storeAs($folderPath, 'photo1.png');
                }

                if ($this->photo2) {
                    $this->photo2->storeAs($folderPath, 'photo2.png');
                }

                $this->pegawai->update([
                    'storage' => $folderToDB,
                ]);
            }

            session()->flash('status', 'Berhasil memperbarui data Pegawai');
            $this->redirect(route('pegawai.index'), navigate: true);
        }, 'Gagal memperbarui data pegawai.', [
            'pegawai_id' => $this->pegawai->id,
            'user_id' => auth()->id(),
            'action' => 'update pegawai',
        ]);
    }

    public function render()
    {
        return view('livewire.handler.pegawai.edit', [
            'list_jabatan' => Jabatan::orderBy('nama_jabatan', 'asc')->get(),
            'list_golongan' => Golongan::orderBy('nama_golongan', 'asc')->get(),
            'list_roles' => Role::orderBy('name', 'asc')->get(),
        ]);
    }
}
