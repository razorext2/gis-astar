<?php

namespace App\Livewire\Handler\Point\Technician;

use App\Models\PointTransactions;
use App\Models\TechnicianPoints;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Redeem extends Component
{
    public $start_period;
    public $end_period;
    public $result;
    public $no_vt = [];
    public $filteredKunjungan = [];

    // public $apiResponse;

    #[Url]
    public $step = 1;

    public function mount()
    {
        $this->start_period = Carbon::now()->subMonths(3)->format('Y-m-26');
        $this->end_period = Carbon::now()->format('Y-m-25');
        $this->result = collect();
    }

    public function prevStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function process()
    {
        $transaction = PointTransactions::where('from_date', '>=', $this->start_period)
            ->where('to_date', '<=', $this->end_period)
            ->exists();

        if ($transaction) {
            dd('data ditemukan. gaboleh transaksi lagi');
        }

        $this->result = TechnicianPoints::with('pegawai')
            ->whereBetween('updated_at', [$this->start_period, $this->end_period])
            ->orderBy('kode_pegawai')
            ->get()
            ->groupBy('kode_pegawai')
            ->toBase();

        $this->step = 2;
    }

    public function searchKunjungan($kode_pegawai)
    {
        $input = $this->no_vt[$kode_pegawai];

        $filtered = $this->result->get($kode_pegawai, collect())
            ->filter(fn($item) => stripos($item->from_vt, $input) !== false)
            ->values();

        $this->filteredKunjungan[$kode_pegawai] = $filtered;
    }

    // this function will used for the next version of this app
    // public function generateMonth()
    // {
    //     $start = Carbon::parse($this->start_period);
    //     $end = Carbon::parse($this->end_period);

    //     $months = [];

    //     while ($start->lt($end)) {
    //         // Untuk setiap periode, ambil bulan setelah $start jika day >= 26
    //         $customMonth = $start->copy()->day >= 26
    //             ? $start->copy()->addMonth()->format('Y-m')
    //             : $start->copy()->format('Y-m');

    //         $months[] = $customMonth;

    //         // Naikkan tanggal ke tanggal 26 bulan berikutnya
    //         $start->addMonth()->day(26);
    //     }

    //     // Pastikan hasilnya unik (jaga-jaga)
    //     return array_unique($months);
    // }

    // this function will used for the next version of this app
    // public function validateData()
    // {
    //     $response = Http::get('https://indodacin.nusa.net.id/web/finger/secureapi.php?tipe=fetchCountPoint');

    //     $data = $response->json();

    //     if (!isset($data['status']) || $data['status'] !== 'success') {
    //         dd('Gagal mengambil data dari API');
    //     }

    //     $this->apiResponse = $data['data'];

    //     $validPegawai = array_flip(array_keys($this->result->toArray())); // ['344' => true, ...]
    //     $validMonths = array_flip($this->generateMonth()); // ['2025-02' => true, '2025-03' => true, ...]

    //     $this->apiResponse = array_filter($this->apiResponse, function ($item) use ($validMonths, $validPegawai) {
    //         return isset($validPegawai[$item['NomorIdentitasTeknisi']]) &&
    //             isset($validMonths[$item['Bulan']]);
    //     });

    //     return $this->apiResponse;
    // }

    // this function will used for the next version of this app
    // public function accumulate()
    // {
    //     $groupedApi = collect($this->validateData())
    //         ->groupBy(fn($item) => (string) $item['NomorIdentitasTeknisi']);

    //     $merged = collect();

    //     // Loop data dari database yang sudah groupBy(kode_pegawai)
    //     foreach ($this->result as $kodePegawai => $dbItems) {
    //         $apiItems = $groupedApi->get($kodePegawai, collect());

    //         $merged->push([
    //             'kode_pegawai' => $kodePegawai,
    //             'pegawai' => $dbItems->first()?->pegawai->full_name ?? 'Teknisi belum terdaftar disistem',
    //             'db_data' => $dbItems,
    //             'api_data' => $apiItems,
    //         ]);
    //     }

    //     return $merged;
    // }


    public function render()
    {
        return view('livewire.handler.point.technician.redeem', [
            'results' => $this->result,
            'step' => $this->step,
        ]);
    }
}
