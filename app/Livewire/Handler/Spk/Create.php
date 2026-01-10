<?php

namespace App\Livewire\Handler\Spk;

use App\Jobs\ExportPdfJob;
use App\Livewire\Concerns\HandlesErrors;
use App\Livewire\Forms\Spk\Create as SpkCreate;
use App\Models\Spk\Production;
use App\Models\Spk\SpkHistory;
use App\Models\Spk\SpkMain;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    use HandlesErrors;

    public SpkCreate $createForm;

    public ?string $nama_barang;

    public ?int $jumlah_unit;

    public ?string $satuan_barang;

    public ?string $spesifikasi = null;

    public bool $showSummary = false;

    public function mount()
    {
        // buat nomor order baru
        $this->createForm->nomor_order = $this->makeNomorOrder($this->createForm->tipe_tagihan)['baru'];
    }

    public function tambahBarang()
    {
        // validasi nama barang
        $this->validate([
            'nama_barang' => 'required|min:5|string',
            'jumlah_unit' => 'required|numeric|min:1',
            'satuan_barang' => 'required|string',
            'spesifikasi' => 'nullable|string',
        ], [
            'nama_barang.required' => 'Kolom nama barang wajib diisi.',
            'nama_barang.min' => 'Kolom nama barang minimal berisi 5 karakter.',
            'nama_barang.string' => 'Kolom nama barang harus berupa string.',
            'jumlah_unit.required' => 'Kolom jumlah unit wajib diisi.',
            'jumlah_unit.numeric' => 'Kolom jumlah unit harus berupa angka.',
            'jumlah_unit.min' => 'Kolom jumlah unit minimal berjumlah 1 buah.',
            'satuan_barang.required' => 'Kolom satuan wajib diisi.',
            'satuan_barang.string' => 'Kolom harus berupa string.',
            'spesifikasi.string' => 'Kolom spesifikasi harus berupa string.',
        ]);

        // assign barang ke array
        $this->createForm->barang[] = [
            'nama_barang' => $this->nama_barang,
            'jumlah_unit' => $this->jumlah_unit,
            'satuan_barang' => $this->satuan_barang,
            'spesifikasi' => $this->spesifikasi,
        ];

        $this->nama_barang = null;
        $this->jumlah_unit = null;
        $this->satuan_barang = null;
        $this->spesifikasi = null;
    }

    public function hapusBarang($index)
    {
        // hapus barang sesuai index
        unset($this->createForm->barang[$index]);

        // refresh value didalam array
        $this->createForm->barang = array_values($this->createForm->barang);
    }

    public function store()
    {
        // cek authorization
        $this->authorize('create', SpkMain::class);

        // validasi form
        $this->createForm->validate();

        // assign data customer ke array
        $customer = [
            'nama_perusahaan' => $this->createForm->nama_customer,
            'alamat' => $this->createForm->alamat_customer ?? '',
            'contact_person' => $this->createForm->contact_person ?? '',
            'no_hp' => $this->createForm->no_telp ?? '',
        ];

        // assign daftar barang ke array
        $barangs = array_values($this->createForm->barang);

        return $this->runSafely(function () use ($barangs, $customer) {
            // tambah data SPK
            $spk = DB::transaction(function () use ($barangs, $customer) {
                $spk = SpkMain::create([
                    'nomor_order' => $this->createForm->nomor_order,
                    'tipe_tagihan' => $this->createForm->tipe_tagihan,
                    'status_nomor_tagihan' => $this->createForm->status_nomor_tagihan,
                    'nomor_tagihan' => $this->createForm->nomor_tagihan,
                    'tipe_bayar' => $this->createForm->tipe_bayar,
                    'tgl_cetak' => $this->createForm->tgl_cetak,
                    'tgl_kirim' => $this->createForm->tgl_kirim <= 1 ? 'SEGERA' : $this->createForm->tgl_kirim,
                    'keterangan' => $this->createForm->keterangan,
                    'customer' => $customer,
                    'products' => $barangs,
                    'status' => 0,
                    'assign_to' => $this->createForm->assign_to,
                    'added_by' => Auth::id(),
                    'update_by' => Auth::id(),
                    'status_approval' => 0,
                ]);

                // tambah data history SPK
                SpkHistory::create([
                    'spk_id' => $spk->id,
                    'title' => 'SPK dibuat.',
                    'keterangan' => Auth::user()->name.' telah membuat SPK baru. Sedang menunggu approval dari tim Management.',
                    'added_by' => Auth::id(),
                ]);

                // tambah data produksi
                Production::create([
                    'id_spk' => $spk->id,
                    'assign_to' => $this->createForm->assign_to,
                    'status_produksi' => 0,
                ]);

                // kembalikan nilai spk
                return $spk;
            });

            // reset dan refresh komponen
            $this->createForm->reset();

            // jalankan job untuk download pdf
            ExportPdfJob::dispatch(
                ['spk-create'],
                'App\Models\Spk\SpkMain',
                $spk->id,
                'f4',
                'portrait',
                'dashboard.pdf.spksummary',
                "SPK $spk->nomor_order anda telah siap untuk didownload. Silahkan klik tombol download dibawah ini:",
                'spk.download');

            // munculkan pesan swal
            $this->dispatch(
                event: 'swal',
                icon: 'success',
                title: 'Berhasil.',
                text: 'Berhasil membuat SPK baru.',
                redirect: [
                    'url' => route('spk.index'),
                    'delay' => 2000,
                ]);
        }, 'Gagal menyimpan data SPK', [
            'form_input' => $this->createForm->all(),
            'user_id' => Auth::id(),
        ]);
    }

    public function summary()
    {
        // validasi form
        // $this->createForm->validate();

        // ambil data dari form createForm
        $spk_data = $this->createForm->all();

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

        // munculkan modal summary
        $this->showSummary = true;

        // munculkan modal pdf
        $this->dispatch('show-pdf-modal', url: route('spk.pdf'));
    }

    private function makeNomorOrder($tipe_tagihan)
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

    public function updatedCreateFormTipeTagihan()
    {
        $this->createForm->nomor_order = $this->makeNomorOrder($this->createForm->tipe_tagihan)['baru'];
    }

    public function render()
    {
        // ambil user dengan role Produksi
        $teamProduksi = User::whereHas('roles', fn ($role) => $role->where('name', 'Produksi'))
            ->get();

        return view('livewire.handler.spk.create', [
            'users' => $teamProduksi,
            'nomor_order_lama' => $this->makeNomorOrder($this->createForm->tipe_tagihan)['lama'],
        ]);
    }
}
