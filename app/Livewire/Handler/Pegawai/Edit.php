<?php

/** Goal: Edit form for employee data, Caller: routes/web.php (pegawai.edit), Deps: Pegawai, User, Spatie Roles, HandlesErrors, PegawaiChangesHistory */

namespace App\Livewire\Handler\Pegawai;

use App\Livewire\Concerns\HandlesErrors;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\PegawaiChangesHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

    // Systemic Employee Code Change Fields
    public bool $ubah_kode_pegawai = false;

    public ?string $kode_pegawai_baru = null;

    public ?string $alasan_ubah_kode = null;

    // User Account Fields (Existing User)
    public $has_account = false;

    public $selected_roles = [];

    public $join_date;

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
            $this->join_date = $user->join_date ? $user->join_date->format('Y-m-d') : null;
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
        $rules = [
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
            'join_date' => 'nullable|date',
            'ubah_kode_pegawai' => 'boolean',
        ];

        if ($this->ubah_kode_pegawai) {
            $rules['kode_pegawai_baru'] = 'required|alpha_num|different:kode_pegawai|unique:tb_pegawai,kode_pegawai';
            $rules['alasan_ubah_kode'] = 'required|string|min:5';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $this->runSafely(function () {
            $old_code = $this->kode_pegawai;
            $new_code = $this->ubah_kode_pegawai ? $this->kode_pegawai_baru : $old_code;
            $alasanLog = $this->ubah_kode_pegawai ? $this->alasan_ubah_kode : 'Pembaruan data pegawai';

            DB::transaction(function () use ($old_code, $new_code, $alasanLog) {
                if ($this->ubah_kode_pegawai && $old_code !== $new_code) {
                    // Update related tables
                    $tables = [
                        'tb_attendance',
                        'tb_attendance_out',
                        'tb_collect',
                        'tb_drivers',
                        'tb_overtime',
                        'tb_point_transactions',
                        'tb_sales',
                        'tb_team_members',
                        'tb_technician',
                        'tb_technician_points',
                        'users',
                    ];

                    foreach ($tables as $table) {
                        DB::table($table)
                            ->where('kode_pegawai', $old_code)
                            ->update(['kode_pegawai' => $new_code]);
                    }

                    // Rename Storage label directory if exists
                    $oldFolder = "public/labels/{$old_code}";
                    $newFolder = "public/labels/{$new_code}";
                    if (Storage::exists($oldFolder)) {
                        Storage::move($oldFolder, $newFolder);
                    }

                    // Record history log
                    PegawaiChangesHistory::create([
                        'pegawai_id' => $this->pegawai->id,
                        'field_name' => 'kode_pegawai',
                        'old_value' => $old_code,
                        'new_value' => $new_code,
                        'alasan' => $this->alasan_ubah_kode,
                        'changed_by' => auth()->id(),
                    ]);
                }

                // Detect dirty changes on other Pegawai fields
                foreach (['nik_pegawai', 'full_name', 'nick_name', 'no_telp', 'alamat', 'jabatan', 'golongan', 'tgl_lahir'] as $field) {
                    if ($this->pegawai->$field != $this->$field) {
                        PegawaiChangesHistory::create([
                            'pegawai_id' => $this->pegawai->id,
                            'field_name' => $field,
                            'old_value' => $this->pegawai->$field,
                            'new_value' => $this->$field,
                            'alasan' => $alasanLog,
                            'changed_by' => auth()->id(),
                        ]);
                    }
                }

                // Update Employee details
                $this->pegawai->update([
                    'kode_pegawai' => $new_code,
                    'nik_pegawai' => $this->nik_pegawai,
                    'full_name' => $this->full_name,
                    'nick_name' => $this->nick_name,
                    'no_telp' => $this->no_telp,
                    'alamat' => $this->alamat,
                    'jabatan' => $this->jabatan,
                    'golongan' => $this->golongan,
                    'tgl_lahir' => $this->tgl_lahir,
                ]);

                // Sync Roles & User params if account exists
                if ($this->has_account) {
                    $user = User::where('kode_pegawai', $new_code)->first();
                    if ($user) {
                        $user->syncRoles($this->selected_roles);

                        if ($user->join_date != $this->join_date) {
                            PegawaiChangesHistory::create([
                                'pegawai_id' => $this->pegawai->id,
                                'field_name' => 'join_date',
                                'old_value' => $user->join_date ? $user->join_date->format('Y-m-d') : null,
                                'new_value' => $this->join_date,
                                'alasan' => $alasanLog,
                                'changed_by' => auth()->id(),
                            ]);
                        }

                        $user->update([
                            'name' => $this->full_name,
                            'join_date' => $this->join_date,
                        ]);
                    }
                }

                // Handle File Uploads
                if ($this->photo1 || $this->photo2) {
                    $folderPath = "public/labels/{$new_code}";
                    $folderToDB = "labels/{$new_code}/";

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
                } elseif ($this->ubah_kode_pegawai && $this->pegawai->storage) {
                    $this->pegawai->update([
                        'storage' => "labels/{$new_code}/",
                    ]);
                }
            });

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
