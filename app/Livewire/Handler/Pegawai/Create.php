<?php

namespace App\Livewire\Handler\Pegawai;

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
    use WithFileUploads;

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
        ];
    }

    public function save()
    {
        $this->validate();

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

        return redirect()->route('pegawai.index')->with('status', 'Berhasil menambah data Pegawai');
    }

    public function render()
    {
        return view('livewire.handler.pegawai.create', [
            'list_jabatan' => Jabatan::all(),
            'list_golongan' => Golongan::all(),
            'list_roles' => Role::all(),
        ]);
    }
}
