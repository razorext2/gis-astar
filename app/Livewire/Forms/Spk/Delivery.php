<?php

namespace App\Livewire\Forms\Spk;

use Illuminate\Support\Str;
use Livewire\Form;

class Delivery extends Form
{
    public ?string $nomor_sr = null;

    public ?string $via = null;

    public ?string $partay = null;

    public ?string $no_container = null;

    public ?string $nama_kapal = null;

    public ?string $no_plat = null;

    public ?string $nama_supir = null;

    public ?string $id_supir = null;

    public ?string $no_telp_supir = null;

    public ?string $berat = null;

    public ?string $etd = null;

    public ?string $eta = null;

    public ?string $note = null;

    public ?array $products = [];

    public ?array $is_delay = [];

    public ?array $history = [];

    protected function rules()
    {
        $rules = [
            'nomor_sr' => 'nullable|string|required_if:via,supir',
            'via' => 'required|string|max:20',
            'partay' => 'nullable|string|max:100|required_if:via,laut',
            'no_container' => 'nullable|string|max:30|required_if:via,laut',
            'nama_kapal' => 'nullable|string|max:100|required_if:via,laut',
            'no_plat' => 'nullable|string|max:20|required_if:via,darat',
            'nama_supir' => 'nullable|string|max:100|required_if:via,darat',
            'no_telp_supir' => 'nullable|string|max:20|required_if:via,darat',
            'berat' => 'nullable|string',
            'etd' => 'required|string',
            'eta' => 'required|string',
            'note' => 'required|string',
            'products' => 'nullable|array',
            'is_delay' => 'nullable|array',
            'history' => 'nullable|array',
        ];

        return $rules;
    }

    protected function messages(): array
    {
        return [

            // nomor_sr
            'nomor_sr.string' => 'Nomor SR harus berupa teks.',
            'nomor_sr.required_if' => 'Nomor SR wajib diisi jika tipe pengiriman adalah supir.',

            // via
            'via.required' => 'Tipe pengiriman wajib dipilih.',
            'via.string' => 'Tipe pengiriman harus berupa teks.',
            'via.max' => 'Tipe pengiriman maksimal 20 karakter.',

            // partay
            'partay.string' => 'Partay harus berupa teks.',
            'partay.max' => 'Partay maksimal 100 karakter.',
            'partay.required_if' => 'Partay wajib diisi jika tipe pengiriman adalah laut.',

            // no_container
            'no_container.string' => 'Nomor container harus berupa teks.',
            'no_container.max' => 'Nomor container maksimal 30 karakter.',
            'no_container.required_if' => 'Nomor container wajib diisi jika tipe pengiriman adalah laut.',

            // nama_kapal
            'nama_kapal.string' => 'Nama kapal harus berupa teks.',
            'nama_kapal.max' => 'Nama kapal maksimal 100 karakter.',
            'nama_kapal.required_if' => 'Nama kapal wajib diisi jika tipe pengiriman adalah laut.',

            // no_plat
            'no_plat.string' => 'Nomor plat kendaraan harus berupa teks.',
            'no_plat.max' => 'Nomor plat kendaraan maksimal 20 karakter.',
            'no_plat.required_if' => 'Nomor plat kendaraan wajib diisi jika tipe pengiriman adalah darat.',

            // nama_supir
            'nama_supir.string' => 'Nama supir harus berupa teks.',
            'nama_supir.max' => 'Nama supir maksimal 100 karakter.',
            'nama_supir.required_if' => 'Nama supir wajib diisi jika tipe pengiriman adalah darat.',

            // no_telp_supir
            'no_telp_supir.string' => 'Nomor telepon supir harus berupa teks.',
            'no_telp_supir.max' => 'Nomor telepon supir maksimal 20 karakter.',
            'no_telp_supir.required_if' => 'Nomor telepon supir wajib diisi jika tipe pengiriman adalah darat.',

            // berat
            'berat.required' => 'Estimasi berat barang wajib diisi.',
            'berat.string' => 'Estimasi berat barang harus berupa teks.',

            // etd
            'etd.required' => 'Estimasi waktu berangkat wajib diisi.',
            'etd.string' => 'Estimasi waktu berangkat harus berupa teks.',

            // eta
            'eta.required' => 'Estimasi waktu sampai wajib diisi.',
            'eta.string' => 'Estimasi waktu sampai harus berupa teks.',

            // note
            'note.required' => 'Catatan wajib diisi.',
            'note.string' => 'Catatan harus berupa teks.',

            // products
            'products.array' => 'Data produk harus berupa array.',

            // is_delay
            'is_delay.array' => 'Data keterlambatan harus berupa array.',

            // history
            'history.array' => 'Data riwayat harus berupa array.',
        ];
    }

    public function generateHistory($status, $desc)
    {
        return [
            'id' => (string) Str::uuid(),
            'status' => $status,
            'desc' => $desc,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function generateViaColor($via)
    {
        return match ($via) {
            'laut' => [
                'color' => 'text-blue-700 bg-blue-400',
                'label' => 'Laut',
            ],
            'darat' => [
                'color' => 'text-green-700 bg-green-400',
                'label' => 'Darat',
            ],
            'supir' => [
                'color' => 'text-gray-700 bg-gray-400',
                'label' => 'Supir Internal',
            ],
            'bycust' => [
                'color' => 'text-yellow-700 bg-yellow-400',
                'label' => 'Dijemput Customer',
            ],
            default => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Tidak diketahui',
            ],
        };
    }

    public function generateStatusColor($status_kirim)
    {
        return match ($status_kirim) {
            0 => [
                'color' => 'text-blue-700 bg-blue-400',
                'label' => 'Dalam Pengiriman',
            ],
            1 => [
                'color' => 'text-green-700 bg-green-400',
                'label' => 'Selesai',
            ],
            2 => [
                'color' => 'text-yellow-700 bg-yellow-400',
                'label' => 'Delay',
            ],
            3 => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Dibatalkan',
            ],
            4 => [
                'color' => 'text-gray-700 bg-gray-400',
                'label' => 'Direschedule',
            ],
            default => [
                'color' => 'text-red-700 bg-red-400',
                'label' => 'Tidak diketahui',
            ],
        };
    }
}
