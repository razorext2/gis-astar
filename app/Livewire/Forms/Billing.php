<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Http;
use Livewire\Form;

class Billing extends Form
{
    public ?string $nomor_tagihan = null;

    public ?string $tipe_tagihan = null;

    public ?bool $status_nomor_tagihan = null;

    public ?string $nama_customer = null;

    public ?string $nomor_tagihan_baru = null;

    public ?float $total_tagihan = 0;

    public ?float $total_bayar = 0;

    public ?float $sisa = 0;

    protected $rules = [
        'nomor_tagihan' => 'required|min:8|string',
        'tipe_tagihan' => 'required:min:4|string',
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

    public function fetchApi(string $baseUrl, string $nomorTagihan): array
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

        if (empty($result['data'][0])) {
            throw new \Exception('Data not found.');
        }

        return $result['data'][0];
    }
}
