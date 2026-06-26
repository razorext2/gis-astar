<?php

/** Goal: Import pegawai data from Excel to update tb_pegawai and users, Caller: ImportPegawai Livewire, Deps: Pegawai, User, Maatwebsite/Excel */

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PegawaiImport implements SkipsEmptyRows, SkipsOnError, SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    protected int $updatedCount = 0;

    /** @var array<int, string> */
    protected array $skippedRows = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $kodePegawai = trim((string) ($row['kode_pegawai'] ?? ''));

            if (empty($kodePegawai)) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_pegawai kosong';

                continue;
            }

            $pegawai = Pegawai::query()->where('kode_pegawai', $kodePegawai)->first();

            if (! $pegawai) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_pegawai "'.$kodePegawai.'" tidak ditemukan';

                continue;
            }

            DB::transaction(function () use ($row, $pegawai, $kodePegawai) {
                $pegawaiData = array_filter([
                    'full_name' => $this->trimOrNull($row['full_name'] ?? null),
                    'nick_name' => $this->trimOrNull($row['nick_name'] ?? null),
                    'no_telp' => $this->trimOrNull($row['no_telp'] ?? null),
                    'alamat' => $this->trimOrNull($row['alamat'] ?? null),
                    'tgl_lahir' => $this->parseDate($row['tgl_lahir'] ?? null),
                    'gender' => $this->parseGender($row['gender'] ?? null),
                ], fn ($value) => $value !== null);

                if (! empty($pegawaiData)) {
                    $pegawai->update($pegawaiData);
                }

                $user = User::query()->where('kode_pegawai', $kodePegawai)->first();

                if ($user) {
                    $userData = array_filter([
                        'name' => $this->trimOrNull($row['full_name'] ?? null),
                        'join_date' => $this->parseDate($row['join_date'] ?? null),
                    ], fn ($value) => $value !== null);

                    if (! empty($userData)) {
                        $user->update($userData);
                    }
                }
            });

            $this->updatedCount++;
        }
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function prepareForValidation(array $data, int $index): array
    {
        if (isset($data['kode_pegawai'])) {
            $data['kode_pegawai'] = (string) $data['kode_pegawai'];
        }

        if (isset($data['no_telp'])) {
            $data['no_telp'] = (string) $data['no_telp'];
        }

        return $data;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'kode_pegawai' => ['required', 'string'],
            'full_name' => ['nullable', 'string', 'max:255'],
            'nick_name' => ['nullable', 'string', 'max:255'],
            'no_telp' => ['nullable', 'string', 'max:50'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'tgl_lahir' => ['nullable'],
            'gender' => ['nullable', 'string'],
            'join_date' => ['nullable'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function customValidationMessages(): array
    {
        return [
            'kode_pegawai.required' => 'Kode pegawai wajib diisi.',
        ];
    }

    public function getUpdatedCount(): int
    {
        return $this->updatedCount;
    }

    /**
     * @return array<int, string>
     */
    public function getSkippedRows(): array
    {
        return $this->skippedRows;
    }

    private function trimOrNull(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return trim((string) $value);
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    private function parseGender(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = strtolower(trim((string) $value));

        return match ($value) {
            'l', 'laki-laki', 'laki', 'male', 'pria' => 'Laki-laki',
            'p', 'perempuan', 'wanita', 'female' => 'Perempuan',
            default => null,
        };
    }
}
