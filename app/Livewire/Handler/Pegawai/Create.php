<?php

namespace App\Livewire\Handler\Pegawai;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    use HandlesErrors, WithFileUploads;

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

    // User Account Fields
    public $make_user = false;

    public $selected_roles = [];

    public $join_date;

    public $is_active = 1;

    public $deactivation_reason;

    // Photo Labels
    public $photo1;

    public $photo2;

    protected function rules()
    {
        return [
            'kode_pegawai' => 'required|unique:tb_pegawai,kode_pegawai',
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
            'selected_roles' => 'required_if:make_user,true|array',
            'join_date' => 'required_if:make_user,true|date',
            'is_active' => 'boolean',
            'deactivation_reason' => 'required_if:is_active,0|nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->runSafely(function () {
            $lastID = Pegawai::latest('id')->first();
            $newID = $lastID ? $lastID->id + 1 : 1;

            $pegawai = Pegawai::create([
                'id' => $newID,
                'kode_pegawai' => $this->kode_pegawai,
                'nik_pegawai' => $this->nik_pegawai,
                'full_name' => $this->full_name,
                'nick_name' => $this->nick_name,
                'no_telp' => $this->no_telp,
                'alamat' => $this->alamat,
                'jabatan' => $this->jabatan,
                'golongan' => $this->golongan,
                'tgl_lahir' => $this->tgl_lahir,
            ]);

            if ($this->make_user) {
                $user = User::create([
                    'kode_pegawai' => $this->kode_pegawai,
                    'name' => $this->full_name,
                    'email' => strtolower($this->nick_name).$this->kode_pegawai.'@indodacin.com',
                    'password' => Hash::make($this->kode_pegawai),
                    'join_date' => $this->join_date,
                    'is_active' => $this->is_active,
                    'deactivation_reason' => $this->is_active == 0 ? $this->deactivation_reason : null,
                    'deactivation_at' => $this->is_active == 0 ? now() : null,
                ]);

                $user->syncRoles($this->selected_roles);
            }

            // Handle File Uploads
            $folderPath = "public/labels/{$this->kode_pegawai}";
            $folderToDB = "labels/{$this->kode_pegawai}/";

            if ($this->photo1 || $this->photo2) {
                if (! Storage::exists($folderPath)) {
                    Storage::makeDirectory($folderPath);
                }

                if ($this->photo1) {
                    $this->photo1->storeAs($folderPath, 'photo1.png');
                }

                if ($this->photo2) {
                    $this->photo2->storeAs($folderPath, 'photo2.png');
                }

                $pegawai->update([
                    'storage' => $folderToDB,
                ]);
            }

            session()->flash('status', 'Berhasil menambah data Pegawai');
            $this->redirect(route('pegawai.index'), navigate: true);
        }, 'Gagal menambahkan data pegawai.', [
            'user_id' => auth()->id(),
            'action' => 'create pegawai',
        ]);
    }

    public function render()
    {
        return view('livewire.handler.pegawai.create', [
            'list_jabatan' => Jabatan::orderBy('nama_jabatan', 'asc')->get(),
            'list_golongan' => Golongan::orderBy('nama_golongan', 'asc')->get(),
            'list_roles' => Role::orderBy('name', 'asc')->get(),
        ]);
    }
}
