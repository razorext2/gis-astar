<?php

namespace App\Livewire\Forms\DailyReport;

use Illuminate\Support\Facades\Http;
use Livewire\Form;

class Project extends Form
{
    public ?string $spk_id = '';

    public ?string $laporan_type = '';

    public ?string $start_date = '';

    public ?string $end_date = '';

    public ?string $deadline = '';

    public ?string $project_name = '';

    public ?string $customer_name = '';

    public ?string $description = '';

    public ?string $no_vt = '';

    public function rules()
    {
        return [
            'spk_id' => 'nullable',
            'laporan_type' => 'nullable',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'deadline' => 'nullable|date|after_or_equal:start_date',
            'project_name' => 'required|string|min:5',
            'customer_name' => 'required|string|min:5',
            'description' => 'required',
            'no_vt' => 'required|string|min:3|max:12|unique:tb_spk_project_assignments,nomor_vt',
        ];
    }

    public function fetch(string $no_vt)
    {
        $base_url = 'https://indodacin.nusa.net.id/web/finger/secureapi.php';

        try {
            // akses api
            $r_kunjungan = Http::get($base_url, [
                'tipe' => 'fetchKunjungan',
                'NomorKunjungan' => $no_vt,
            ]);

            // ambil data json
            $res_kunjungan = $r_kunjungan->json();

            if (! $r_kunjungan->successful() || $res_kunjungan['status'] !== 'success') { // jika status error, tampilkan error
                throw new \Exception('Fetch api gagal, terjadi kesalahan saat fetch data fetchKunjungan.');
            }

            // inisialisasi data
            $data = $res_kunjungan['data'][0];

            // inisialisasi id dan tanggal
            $id_permintaan_kunjungan = $data['IDPermintaanKunjungan'];
            $tanggal_kunjungan = $data['TanggalKunjungan'];
            $customer_contact = $data['CustomerContact'];

            // akses api
            $r_relasi = Http::get($base_url, [
                'tipe' => 'fetchKunjunganRelasi',
                'IDPermintaanKunjungan' => $id_permintaan_kunjungan,
                'TanggalKunjungan' => $tanggal_kunjungan,
            ]);

            // ambil data json
            $res_relasi = $r_relasi->json();

            // set ulang data
            $hasil = [];
            $hasil['data']['partner'] = $res_relasi['data'];
            $hasil['data']['CustomerContact'] = $customer_contact;

            if (! $r_relasi->successful() || $res_relasi['status'] !== 'success') { // jika status error, tampilkan error
                throw new \Exception('Fetch api gagal, terjadi kesalahan saat fetch data fetchKunjunganRelasi.');
            }

            return $hasil['data'];
        } catch (\Exception $e) {
            // tampilkan error jika api fetchKunjungan gagal dipanggil
            throw new \Exception('Failed to fetch data from external API fetchKunjungan: '.$e->getMessage());
        }
    }
}
