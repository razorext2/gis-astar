<?php

/** Goal: Form object untuk data billing SPK — validasi input dan fetch dari API eksternal, Caller: BillingUpdate Livewire component, Deps: Http */

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Http;
use Livewire\Form;

class Billing extends Form
{
    public ?string $nomor_tagihan = null;

    public ?string $tipe_tagihan = null;

    public ?bool $status_nomor_tagihan = null;

    public ?string $nama_customer = null;

    public ?string $customer_contact = null;

    public ?string $nomor_tagihan_baru = null;

    /** Nilai SubTotal dari API fetchSR* (sebelum DP/PPN) */
    public ?float $subtotal = 0;

    /** Nilai Total dari API fetchSR* (setelah DP dan/atau PPN) */
    public ?float $total = 0;

    /** Field yang dipilih user sebagai acuan jumlah piutang: 'subtotal' atau 'total' */
    public string $jumlah_piutang_field = 'subtotal';

    /** Jumlah piutang yang digunakan untuk perhitungan (subtotal atau total, tergantung pilihan) */
    public ?float $jumlah_piutang = 0;

    public ?float $total_bayar = 0;

    public ?float $sisa = 0;

    protected $rules = [
        'nomor_tagihan' => 'required|min:8|string',
        'tipe_tagihan' => 'required|min:4|string',
    ];

    protected $messages = [
        'nomor_tagihan.required' => 'Nomor tagihan harus diisi.',
        'nomor_tagihan.min' => 'Nomor tagihan minimal 8 karakter.',
        'nomor_tagihan.string' => 'Nomor tagihan harus berupa string.',
        'tipe_tagihan.required' => 'Tipe tagihan harus diisi.',
        'tipe_tagihan.min' => 'Tipe tagihan minimal 4 karakter.',
        'tipe_tagihan.string' => 'Tipe tagihan harus berupa string.',
    ];

    public function sanitizeAlphaNumeric(string $text): string
    {
        return strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $text));
    }

    /**
     * Fetch satu baris pertama dari API (digunakan untuk fetchSR / fetchSR3 / fetchSR2).
     *
     * @return array<string, mixed>
     */
    public function fetchApi(string $baseUrl, string $nomorTagihan): array
    {
        $data = $this->sendRequest($baseUrl, $nomorTagihan);

        if (empty($data[0])) {
            throw new \Exception('Data not found.');
        }

        return $data[0];
    }

    /**
     * Fetch semua baris dari API fetchSisa* yang bisa mengembalikan lebih dari 1 record per NomorPiutang.
     *
     * @return array<int, array<string, mixed>>
     */
    public function fetchSisa(string $baseUrl, string $nomorTagihan): array
    {
        $data = $this->sendRequest($baseUrl, $nomorTagihan);

        if (empty($data)) {
            throw new \Exception('Data not found.');
        }

        return $data;
    }

    /**
     * Hitung jumlah_piutang berdasarkan pilihan field user.
     * Default per tipe_tagihan: idcnon → subtotal, idcppn → subtotal, idyppn → total.
     */
    public function resolveDefaultJumlahPiutangField(): string
    {
        return match ($this->tipe_tagihan) {
            'idyppn' => 'total',
            default => 'subtotal',
        };
    }

    /**
     * Kirim HTTP request ke API dan validasi response-nya.
     * Throws exception jika request gagal atau status bukan 'success'.
     *
     * @return array<int, array<string, mixed>>
     */
    private function sendRequest(string $baseUrl, string $nomorTagihan): array
    {
        $response = Http::timeout(10)
            ->retry(2, 300)
            ->get($baseUrl.'&NomorPermintaanJual='.$nomorTagihan);

        if (! $response->successful()) {
            throw new \Exception('Failed to fetch data from external API.');
        }

        $result = $response->json();

        if (! isset($result['status']) || $result['status'] !== 'success') {
            throw new \Exception($result['message'] ?? 'Invalid API response.');
        }

        return $result['data'] ?? [];
    }
}
