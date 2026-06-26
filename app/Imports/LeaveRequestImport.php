<?php

/** Goal: Import historical leave request data from Excel, Caller: ImportLeaveRequest Livewire, Deps: LeaveRequest, LeaveType, User, LeaveBalance, Maatwebsite/Excel */

namespace App\Imports;

use App\Models\LeaveRequest\LeaveBalance;
use App\Models\LeaveRequest\LeaveRequest;
use App\Models\LeaveRequest\LeaveRequestHistory;
use App\Models\LeaveRequest\LeaveType;
use App\Models\User;
use App\Services\LeaveRequest\LeaveRequestService;
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

class LeaveRequestImport implements SkipsEmptyRows, SkipsOnError, SkipsOnFailure, ToCollection, WithHeadingRow, WithValidation
{
    use Importable, SkipsErrors, SkipsFailures;

    protected int $importedCount = 0;

    /** @var array<int, string> */
    protected array $skippedRows = [];

    /** @var array<string, LeaveType> */
    protected array $leaveTypeCache = [];

    /** @var array<string, User> */
    protected array $userCache = [];

    public function collection(Collection $rows): void
    {
        $service = app(LeaveRequestService::class);

        foreach ($rows as $index => $row) {
            $kodePegawai = trim((string) ($row['kode_pegawai'] ?? ''));
            $kodeCuti = strtoupper(trim((string) ($row['kode_cuti'] ?? '')));

            if (empty($kodePegawai)) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_pegawai kosong';

                continue;
            }

            if (empty($kodeCuti)) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_cuti kosong';

                continue;
            }

            $user = $this->resolveUser($kodePegawai);
            if (! $user) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_pegawai "'.$kodePegawai.'" tidak ditemukan';

                continue;
            }

            $leaveType = $this->resolveLeaveType($kodeCuti);
            if (! $leaveType) {
                $this->skippedRows[] = 'Baris '.($index + 2).': kode_cuti "'.$kodeCuti.'" tidak ditemukan';

                continue;
            }

            $startDate = $this->parseDate($row['tanggal_mulai'] ?? null);
            $endDate = $this->parseDate($row['tanggal_selesai'] ?? null);

            if (! $startDate || ! $endDate) {
                $this->skippedRows[] = 'Baris '.($index + 2).': tanggal_mulai atau tanggal_selesai tidak valid';

                continue;
            }

            if ($startDate > $endDate) {
                $this->skippedRows[] = 'Baris '.($index + 2).': tanggal_mulai lebih besar dari tanggal_selesai';

                continue;
            }

            $totalDays = (int) ($row['total_hari'] ?? 0);
            if ($totalDays <= 0) {
                $this->skippedRows[] = 'Baris '.($index + 2).': total_hari harus lebih dari 0';

                continue;
            }

            $reason = trim((string) ($row['alasan'] ?? 'Data cuti lama (import)'));

            $exists = LeaveRequest::query()
                ->where('user_id', $user->id)
                ->where('leave_type_id', $leaveType->id)
                ->where('start_date', $startDate)
                ->where('end_date', $endDate)
                ->exists();

            if ($exists) {
                $this->skippedRows[] = 'Baris '.($index + 2).': data cuti sudah ada (pegawai: '.$kodePegawai.', kode cuti: '.$kodeCuti.', '.$startDate.' s/d '.$endDate.')';

                continue;
            }

            DB::transaction(function () use ($user, $leaveType, $startDate, $endDate, $totalDays, $reason, $service) {
                $returnDate = $service->calculateReturnDate($endDate);

                $request = LeaveRequest::withoutEvents(fn () => LeaveRequest::create([
                    'user_id' => $user->id,
                    'leave_type_id' => $leaveType->id,
                    'backup_person_id' => null,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'return_date' => $returnDate,
                    'total_days' => $totalDays,
                    'reason' => $reason,
                    'status' => 'approved',
                    'attachments' => [],
                    'is_borrowed' => false,
                ]));

                LeaveRequestHistory::create([
                    'leave_request_id' => $request->id,
                    'acted_by' => auth()->id(),
                    'action' => 'import',
                    'status_from' => 'approved',
                    'status_to' => 'approved',
                    'note' => 'Data cuti lama diimport oleh '.auth()->user()->name,
                ]);

                if ($leaveType->is_anual_deduction) {
                    $year = Carbon::parse($startDate)->year;

                    $balance = LeaveBalance::firstOrCreate(
                        ['user_id' => $user->id, 'year' => $year],
                        ['total_quota' => $leaveType->default_days, 'used_quota' => 0]
                    );

                    $balance->increment('used_quota', $totalDays);

                    LeaveRequestHistory::create([
                        'leave_request_id' => $request->id,
                        'acted_by' => auth()->id(),
                        'action' => 'quota_deducted',
                        'status_from' => 'approved',
                        'status_to' => 'approved',
                        'note' => "Kuota dipotong (import): {$totalDays} hari",
                    ]);
                }
            });

            $this->importedCount++;
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

        if (isset($data['total_hari'])) {
            $data['total_hari'] = (string) $data['total_hari'];
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
            'kode_cuti' => ['required', 'string'],
            'tanggal_mulai' => ['required'],
            'tanggal_selesai' => ['required'],
            'total_hari' => ['required', 'numeric', 'min:1'],
            'alasan' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function customValidationMessages(): array
    {
        return [
            'kode_pegawai.required' => 'Kode pegawai wajib diisi.',
            'kode_cuti.required' => 'Kode cuti wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'total_hari.required' => 'Total hari wajib diisi.',
            'total_hari.min' => 'Total hari minimal 1.',
        ];
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * @return array<int, string>
     */
    public function getSkippedRows(): array
    {
        return $this->skippedRows;
    }

    protected function resolveUser(string $kodePegawai): ?User
    {
        if (! array_key_exists($kodePegawai, $this->userCache)) {
            $this->userCache[$kodePegawai] = User::query()
                ->where('kode_pegawai', $kodePegawai)
                ->first();
        }

        return $this->userCache[$kodePegawai];
    }

    protected function resolveLeaveType(string $code): ?LeaveType
    {
        if (! array_key_exists($code, $this->leaveTypeCache)) {
            $this->leaveTypeCache[$code] = LeaveType::query()
                ->where('code', $code)
                ->first();
        }

        return $this->leaveTypeCache[$code];
    }

    protected function parseDate(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(Date::excelToDateTimeObject($value))->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
