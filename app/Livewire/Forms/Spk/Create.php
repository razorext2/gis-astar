<?php

/** Goal: Holds form state and validation logic for creating SPKs, Caller: App/Livewire/Handler/Spk/Create.php, Deps: SpkHistory, SpkMain, User */

namespace App\Livewire\Forms\Spk;

use App\Models\Spk\SpkHistory;
use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;

class Create extends Form
{
    public ?string $spk_id = null;

    public ?int $status_approval = null;

    public ?bool $is_changed = false;

    public ?string $nama_customer;

    public ?string $no_telp;

    public ?string $contact_person;

    public ?string $alamat_customer;

    public ?string $tipe_timbangan = null;

    public ?string $tipe_tagihan = null;

    public ?string $nomor_tagihan = null;

    public ?string $nomor_order;

    public ?string $nomor_dokumen_penawaran = null;

    public ?string $tipe_bayar;

    public ?string $tgl_cetak;

    public ?string $tgl_kirim;

    public ?string $keterangan;

    public ?string $revision_request_detail = null;

    public ?int $assign_to = null;

    public ?int $status_nomor_tagihan = 0;

    public ?array $barang = [];

    public ?bool $is_booked = false;

    public ?bool $is_using_company_driver = false;

    public ?bool $is_picked_up_by_customer = false;

    protected function rules(): array
    {
        $rules = [
            'nama_customer' => 'required|max:255|string',
            'no_telp' => 'nullable|max:255|string',
            'contact_person' => 'nullable|max:255|string',
            'alamat_customer' => 'nullable|string',
            'tipe_timbangan' => 'required_if:is_booked,false|nullable|string',
            'barang' => 'required|array|min:1',
            'tipe_tagihan' => 'required|string|in:idcnon,idcppn,idyppn',
            'status_nomor_tagihan' => 'required|integer|in:0,1',
            'nomor_tagihan' => 'nullable|string|max:255|required_if:status_nomor_tagihan,1',
            'nomor_order' => 'required|string|max:255|unique:App\Models\Spk\SpkMain,nomor_order',
            'nomor_dokumen_penawaran' => 'nullable|string|min:5|max:255',
            'tipe_bayar' => 'required|string|in:Cash,Bon',
            'tgl_cetak' => 'date',
            'tgl_kirim' => 'integer',
            'keterangan' => 'required|string',
            'assign_to' => 'required_if:is_booked,false|nullable|integer',
            'is_booked' => 'boolean',
            'is_using_company_driver' => 'boolean',
            'is_picked_up_by_customer' => 'boolean',
        ];

        if ($this->spk_id) {
            $rules['nomor_order'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('tb_spk', 'nomor_order')
                    ->ignore($this->spk_id),
            ];

            if (auth()->user()->cannot('spk_validate') && $this->status_approval === 1 && $this->is_changed) {
                $rules['revision_request_detail'] = [
                    'required',
                    'string',
                    'min:10',
                    'max:255',
                ];
            }
        }

        return $rules;
    }

    protected array $messages = [
        // nama_customer
        'nama_customer.required' => 'Kolom nama bon customer wajib diisi.',
        'nama_customer.max' => 'Kolom nama bon customer maksimal 255 karakter.',
        'nama_customer.string' => 'Kolom nama bon customer harus berupa teks.',

        // no_telp
        'no_telp.max' => 'Kolom nomor telepon customer maksimal 255 karakter.',
        'no_telp.string' => 'Kolom nomor telepon customer harus berupa teks.',

        // contact_person
        'contact_person.max' => 'Kolom contact person maksimal 255 karakter.',
        'contact_person.string' => 'Kolom contact person harus berupa teks.',

        // alamat_customer
        'alamat_customer.string' => 'Kolom alamat customer harus berupa teks.',

        // tipe_timbangan
        'tipe_timbangan.required' => 'Kolom tipe timbangan wajib diisi.',
        'tipe_timbangan.string' => 'Kolom tipe timbangan harus berupa teks.',

        // barang
        'barang.required' => 'Kolom daftar barang wajib diisi.',
        'barang.array' => 'Kolom daftar barang harus berupa array.',
        'barang.min' => 'Kolom daftar barang minimal berisi satu barang.',

        // tipe_tagihan
        'tipe_tagihan.required' => 'Kolom tipe tagihan wajib diisi.',
        'tipe_tagihan.string' => 'Kolom tipe tagihan harus berupa teks.',
        'tipe_tagihan.in' => 'Pilihan tipe tagihan tidak valid.',

        // status_nomor_tagihan
        'status_nomor_tagihan.required' => 'Kolom status nomor tagihan wajib diisi.',
        'status_nomor_tagihan.integer' => 'Kolom status nomor tagihan harus berupa angka.',
        'status_nomor_tagihan.in' => 'Pilihan status nomor tagihan tidak valid.',

        // nomor_tagihan
        'nomor_tagihan.string' => 'Kolom nomor tagihan harus berupa teks.',
        'nomor_tagihan.max' => 'Kolom nomor tagihan maksimal 255 karakter.',
        'nomor_tagihan.required_if' => 'Kolom nomor tagihan wajib diisi ketika status nomor tagihan sudah ada.',

        // nomor_order
        'nomor_order.required' => 'Kolom nomor order wajib diisi.',
        'nomor_order.string' => 'Kolom nomor order harus berupa teks.',
        'nomor_order.max' => 'Kolom nomor order maksimal 255 karakter.',
        'nomor_order.unique' => 'Nomor order sudah digunakan, silahkan input nomor order baru.',

        // nomor_dokumen_penawaran
        'nomor_dokumen_penawaran.string' => 'Kolom nomor dokumen penawaran harus berupa teks.',
        'nomor_dokumen_penawaran.min' => 'Kolom nomor dokumen penawaran minimal 5 karakter.',
        'nomor_dokumen_penawaran.max' => 'Kolom nomor dokumen penawaran maksimal 255 karakter.',
        'nomor_dokumen_penawaran.unique' => 'Nomor dokumen penawaran sudah digunakan, silahkan input nomor dokumen penawaran baru.',

        // tipe_bayar
        'tipe_bayar.required' => 'Kolom tipe bayar wajib diisi.',
        'tipe_bayar.string' => 'Kolom tipe bayar harus berupa teks.',
        'tipe_bayar.in' => 'Pilihan tipe bayar tidak valid.',

        // tgl_cetak
        'tgl_cetak.date' => 'Format tanggal cetak tidak valid.',

        // tgl_kirim
        'tgl_kirim.integer' => 'Format tanggal kirim tidak valid.',

        // keterangan
        'keterangan.required' => 'Kolom keterangan wajib diisi.',
        'keterangan.string' => 'Kolom keterangan harus berupa teks.',

        // assign_to
        'assign_to.required' => 'Kolom assign to wajib diisi.',
        'assign_to.integer' => 'Kolom assign to harus berupa angka.',

        // is_booked
        'is_booked.boolean' => 'Kolom is booked harus berupa boolean.',

        // is_using_company_driver
        'is_using_company_driver.boolean' => 'Kolom is using driver company harus berupa boolean.',
    ];

    public function makeNomorOrder($tipe_tagihan)
    {
        // ambil nomor_order terakhir sesuai tipe tagihan
        $lastNomorOrder = SpkMain::select('nomor_order')
            ->where('tipe_tagihan', $tipe_tagihan)
            ->get()
            ->last();

        // set array romawi untuk bulan
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        // jika lastNomorOrder ada
        if ($lastNomorOrder) {
            // 000.05/X/25
            $lastBulanNomorUrut = $this->diffBulanUrut($lastNomorOrder->nomor_order); // return bulan 10 (sesuai nomor_order terakhir)
            $lastNomorUrut = $this->ambilNomorUrut($lastNomorOrder->nomor_order); // return 6 ( 5 + 1 )
            $bulanSekarang = $bulanRomawi[today()->month]; // XI
            $tahunSekarang = today()->year; // 2025

            // jika bulan sekarang lebih besar dari bulan nomor urut terakhir
            if (today()->month > $lastBulanNomorUrut || (today()->month == 1 && $lastBulanNomorUrut == 12)) {
                $lastNomorUrut = 1;
            } else {
                $lastNomorUrut++;
            }

            // format nomor urut
            $formatNomorUrut = $this->formatNomor($lastNomorUrut, $tipe_tagihan);

            // buat nomor order
            $nomorOrderBaru = '000.'.$formatNomorUrut.'/'.$bulanSekarang.'/'.$tahunSekarang; // 000.06/XI/2025
        } else {
            // format nomor urut
            $formatNomorUrut = $this->formatNomor(1, $tipe_tagihan);

            // buat nomor order
            $nomorOrderBaru = '000.'.$formatNomorUrut.'/'.$bulanRomawi[today()->month].'/'.today()->year; // 000.06/XI/2025
        }

        // kembalikan nilai nomor order lama dan baru
        return [
            'lama' => $lastNomorOrder->nomor_order ?? '-',
            'baru' => $nomorOrderBaru,
        ];
    }

    private function ambilNomorUrut($nomor_order)
    {
        // cari karakter setelah titik pertama
        $awal = strpos($nomor_order, '.') + 1;

        // cari posisi garis miring terdekat setelah titik
        $akhir = strpos($nomor_order, '/', $awal);

        // ambil nilai di antara titik dan slash
        $angka = substr($nomor_order, $awal, $akhir - $awal);

        // kembalikan nilai
        return $angka;
    }

    private function diffBulanUrut($nomor_order)
    {
        // inisialisasi array bulan
        $bulanArray = [
            'I' => 1,
            'II' => 2,
            'III' => 3,
            'IV' => 4,
            'V' => 5,
            'VI' => 6,
            'VII' => 7,
            'VIII' => 8,
            'IX' => 9,
            'X' => 10,
            'XI' => 11,
            'XII' => 12,
        ];

        // cari posisi slash pertama
        $awal = strpos($nomor_order, '/') + 1;

        // cari posisi slash terdekat setelah slash pertama
        $akhir = strpos($nomor_order, '/', $awal);

        // ambil nilai diantara slash pertama dan setelahnya
        $bulanRomawi = substr($nomor_order, $awal, $akhir - $awal); // return X

        // ambil nilai
        $bulan = $bulanArray[$bulanRomawi]; // return sesuai array, 10

        // kembalikan nilai
        return $bulan;
    }

    private function formatNomor($nomor_urut, $tipe_tagihan)
    {
        // konversi ke string
        $angka = (string) $nomor_urut;

        // jika tipe tagihan idcppn
        if ($tipe_tagihan === 'idcppn') {
            // return str_pad($angka, 2, '0', STR_PAD_LEFT); minimal 2 digit
            return str_pad($angka, 2, '0', STR_PAD_LEFT);
        }

        // jika tipe tagihan idcnon
        if ($tipe_tagihan === 'idcnon') {
            // hitung panjang angka
            $panjang = strlen($angka);

            // jika panjang angka besar sama dengan 3
            if ($panjang >= 3) {
                // return angka dengan 0 didepannya
                return '0'.$angka;
            }

            // return str_pad($angka, 3, '0', STR_PAD_LEFT); minimal 3 digit
            return str_pad($angka, 3, '0', STR_PAD_LEFT);
        }

        // return nilai
        return $angka;
    }

    public function stream()
    {
        // validasi form
        $this->validate();

        // ambil data dari form createForm
        $spk_data = $this->all();

        // generate id
        $spk_data['id'] = Str::uuid();

        // siapa yg bikin spk nya
        $spk_data['added_by'] = Auth::user()->name;
        $spk_data['added_by_signature_img'] = Auth::user()?->signature?->getSignatureImagePath() ?? null;

        // assign user yang sedang login
        $spk_data['assign_to'] = User::find($spk_data['assign_to'])->name ?? '';
        $spk_data['assign_to_signature_img'] = User::find($spk_data['assign_to'])?->signature?->getSignatureImagePath() ?? null;

        // ttd bu tini
        // $spk_data['bu_tini_signature_img'] = User::find(1105)?->signature?->getSignatureImagePath() ?? 'Not set';

        // buat session untuk data spk ke pdf
        session(['spk_pdf_data' => $spk_data]);
    }

    public function generateCustomerData(): array
    {
        return [
            'nama_perusahaan' => $this->nama_customer,
            'alamat' => $this->alamat_customer ?? '',
            'contact_person' => $this->contact_person ?? '',
            'no_hp' => $this->no_telp ?? '',
        ];
    }

    public function moveItem(int $from, int $to)
    {
        if (! isset($this->barang[$from]) || $to < 0 || $to >= count($this->barang)) {
            return;
        }

        $item = $this->barang[$from];

        unset($this->barang[$from]);

        $this->barang = array_values($this->barang);

        array_splice($this->barang, $to, 0, [$item]);
    }
}
