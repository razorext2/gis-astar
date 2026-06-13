<?php

/** Goal: Gemini API service with function calling using Interactions API, Caller: Chatbot Livewire, Deps: config/services.php */

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;

    private string $model;

    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key', '');
        $this->model = config('services.gemini.model', 'gemini-3.1-flash');
    }

    /**
     * Kirim pesan ke Gemini API menggunakan Interactions API.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     * @return array{content: string, interaction_id: string|null, error: string|null}
     */
    public function sendMessage(array $history, string $userMessage, ?string $previousInteractionId = null, array $userContext = []): array
    {
        if (empty($this->apiKey)) {
            return [
                'content' => '',
                'interaction_id' => $previousInteractionId,
                'error' => 'GEMINI_API_KEY belum dikonfigurasi. Silakan tambahkan di file .env',
            ];
        }

        $systemInstruction = $this->buildSystemInstruction($userContext);
        $tools = $this->buildTools();
        $model = $this->model;

        // Payload turn awal
        $payload = [
            'model' => $model,
            'input' => $userMessage,
            'tools' => $tools,
            'system_instruction' => $systemInstruction,
            'generation_config' => [
                'temperature' => 0.7,
            ],
            'store' => true,
        ];

        if ($previousInteractionId) {
            $payload['previous_interaction_id'] = $previousInteractionId;
        }

        $interactionId = $previousInteractionId;
        $maxRounds = 5;

        for ($round = 0; $round < $maxRounds; $round++) {
            $response = Http::timeout(60)
                ->post("{$this->baseUrl}/interactions?key={$this->apiKey}", $payload);

            if (! $response->successful()) {
                $errorBody = $response->json();
                $errorMsg = $errorBody['error']['message'] ?? 'API request failed';
                Log::error('Gemini Interactions API error', ['status' => $response->status(), 'body' => $errorBody]);

                return [
                    'content' => '',
                    'interaction_id' => $interactionId,
                    'error' => "Gemini API Error: {$errorMsg}",
                ];
            }

            $data = $response->json();
            $interactionId = $data['id'] ?? $interactionId;
            $steps = $data['steps'] ?? [];

            // Cari jika ada step bertipe function_call
            $functionCall = collect($steps)->firstWhere('type', 'function_call');

            if ($functionCall) {
                $fnName = $functionCall['name'] ?? '';
                $fnArgs = $functionCall['arguments'] ?? $functionCall['args'] ?? [];
                $callId = $functionCall['id'] ?? '';

                $fnResult = $this->executeFunction($fnName, $fnArgs);

                // Payload untuk membalas function call
                $payload = [
                    'model' => $model,
                    'previous_interaction_id' => $interactionId,
                    'input' => [
                        [
                            'type' => 'function_result',
                            'name' => $fnName,
                            'call_id' => $callId,
                            'result' => [
                                [
                                    'type' => 'text',
                                    'text' => json_encode(['result' => $fnResult]),
                                ],
                            ],
                        ],
                    ],
                    'tools' => $tools,
                    'system_instruction' => $systemInstruction,
                    'generation_config' => [
                        'temperature' => 0.7,
                    ],
                    'store' => true,
                ];

                continue;
            }

            // Cari step bertipe model_output terakhir
            $modelOutputStep = collect($steps)->where('type', 'model_output')->last();
            if ($modelOutputStep && ! empty($modelOutputStep['content'])) {
                $textParts = [];
                foreach ($modelOutputStep['content'] as $content) {
                    if (($content['type'] ?? '') === 'text' && isset($content['text'])) {
                        $textParts[] = $content['text'];
                    }
                }
                $text = implode('', $textParts);

                return [
                    'content' => $text ?: 'Tidak ada respons teks dari AI.',
                    'interaction_id' => $interactionId,
                    'error' => null,
                ];
            }

            return [
                'content' => 'Tidak ada output dari AI.',
                'interaction_id' => $interactionId,
                'error' => null,
            ];
        }

        return [
            'content' => '',
            'interaction_id' => $interactionId,
            'error' => 'Terlalu banyak function call rounds',
        ];
    }

    /**
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    private function buildSystemInstruction(array $userContext = []): string
    {
        $schema = $this->getDatabaseSchemaDescription();
        $permissionBlock = $this->buildPermissionContextBlock($userContext);
        $currentTime = now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i:s');
        $baseUrl = rtrim(config('app.url', 'https://indodacin.dev'), '/');

        return <<<PROMPT
Kamu adalah **Dacin AI**, asisten kerja cerdas milik **PT Indodacin Presisi Utama** — perusahaan manufaktur timbangan terbaik di Indonesia.

## Waktu Saat Ini
- Hari/Tanggal/Waktu: {$currentTime} (WIB / Asia/Jakarta)
- Gunakan tanggal ini sebagai referensi utama untuk semua pertanyaan tentang "hari ini", "kemarin", "bulan ini", "minggu ini", atau pertanyaan berbasis waktu lainnya.

## Kepribadian
- Sopan, profesional, dan berwibawa
- Gunakan bahasa Indonesia yang sopan tapi santai
- Jika user bertanya dalam bahasa Inggris, jawab dalam bahasa Inggris
- Kamu memberikan response straight to the point, padat, jelas, dan mudah dimengerti
- Jangan pernah memberikan lebih dari 2 kali response dalam 1 kali chat

## Kemampuan
1. **Pencarian Data** — Kamu bisa query database aplikasi (READ-ONLY) untuk membantu user mencari data pegawai, absensi, piutang, SPK, driver, sales, invoice, notifikasi, dll.
2. **Ringkasan & Analisis** — Berikan summary dan insight dari data yang ditemukan
3. **Saran Aksi** — Setelah menampilkan data, sarankan langkah selanjutnya yang bisa dilakukan user
4. **General Chat** — Kamu juga bisa ngobrol santai, menjawab pertanyaan umum, atau membantu brainstorming, namun kamu tidak boleh membahas terlalu jauh suatu hal diluar dari PT. Indodacin Presisi Utama ataupun produk produk yang dijual (Timbangan).

## Aturan Navigasi & Link URL
- Kamu memiliki izin untuk memberikan link navigasi aplikasi kepada user. Kamu WAJIB memberikan link URL aktif ke halaman terkait jika user menanyakan link atau meminta diarahkan ke halaman tersebut.
- Kamu WAJIB memformat link sebagai hyperlink markdown standard menggunakan base URL: {$baseUrl}. Contoh: [Data Pegawai]({$baseUrl}/dashboard/pegawai).
- JANGAN PERNAH menggunakan domain indodacin.id, indodacin.co.id, atau domain eksternal lainnya. Gunakan base URL {$baseUrl} saja.
- Gunakan daftar link navigasi resmi di bawah ini untuk menghasilkan tautan yang benar (JANGAN gunakan backticks ` pada hasil akhir hyperlink markdown):
  - Dashboard Utama: [Dashboard]({$baseUrl}/dashboard)
  - Data Pegawai: [Data Pegawai]({$baseUrl}/dashboard/pegawai)
  - Detail Pegawai Spesifik: [Detail Pegawai]({$baseUrl}/dashboard/pegawai/{id}/detail) (ganti {id} dengan ID/kode pegawai yang sesuai)
  - Absensi Masuk: [Absensi Masuk]({$baseUrl}/dashboard/attendanceIn)
  - Absensi Keluar: [Absensi Keluar]({$baseUrl}/dashboard/attendanceOut)
  - Pengajuan Cuti Saya: [Pengajuan Cuti Saya]({$baseUrl}/dashboard/leave-request/my-requests)
  - Persetujuan Cuti (Approval Center): [Persetujuan Cuti]({$baseUrl}/dashboard/leave-request/approval-center)
  - Laporan Kolektor (Piutang): [Laporan Kolektor]({$baseUrl}/dashboard/collect)
  - Surat Perintah Kerja (SPK): [SPK]({$baseUrl}/dashboard/spk/spk)
  - Laporan Driver: [Laporan Driver]({$baseUrl}/dashboard/driver)
  - Laporan Sales: [Laporan Sales]({$baseUrl}/dashboard/sales)
  - Laporan Teknisi: [Laporan Teknisi]({$baseUrl}/dashboard/technician)
  - Manajemen Divisi: [Divisi]({$baseUrl}/dashboard/division)
  - Manajemen Jabatan: [Jabatan]({$baseUrl}/dashboard/jabatan)
  - Penempatan Kerja: [Penempatan]({$baseUrl}/dashboard/placement)
  - Poin Teknisi: [Poin Teknisi]({$baseUrl}/dashboard/points)
  - Akun Pengguna (Users): [Akun Pengguna]({$baseUrl}/dashboard/users)
  - Hak Akses (Roles/Permissions): [Roles]({$baseUrl}/dashboard/roles) dan [Permissions]({$baseUrl}/dashboard/permissions)

## Aturan Penting
- **HANYA SELECT** — Kamu TIDAK boleh melakukan INSERT, UPDATE, DELETE, DROP, atau operasi write apapun
- Jika query menghasilkan banyak data, tampilkan dalam format tabel markdown
- JANGAN tampilkan raw SQL ke user, cukup tampilkan hasilnya dalam format yang mudah dibaca
- Limit query max 50 rows untuk performa
- Jika user meminta sesuatu yang butuh modifikasi data, arahkan mereka ke menu yang tepat di dashboard
- **WAJIB PERIKSA AKSES** — Sebelum mengambil data apapun dari database, periksa apakah user memiliki permission yang dibutuhkan di bagian "Konteks User & Hak Akses" di bawah. Jika TIDAK punya akses, JANGAN query database dan langsung balas dengan pesan bahwa user tidak memiliki izin untuk mengakses data tersebut.
- **WAJIB JOIN RELASI (PENTING)** — Jangan pernah menampilkan raw ID / integer dari kolom relasi/foreign key kepada user (misalnya menampilkan ID `11` alih-alih nama divisi, atau ID `8` alih-alih nama jabatan). Kamu WAJIB menggunakan SQL `JOIN` ke tabel relasi terkait untuk mengambil nama aslinya yang representatif (misal: `JOIN tb_division ON tb_jabatan.divisi = tb_division.id` untuk mengambil `nama_divisi`, `JOIN tb_jabatan` untuk mengambil `nama_jabatan` pegawai, `JOIN tb_golongan` untuk mengambil `nama_golongan`, atau `JOIN tb_placement` untuk mengambil lokasi `penempatan`).
- **JANGAN PERNAH SEBUT NAMA DATABASE** — Kamu dilarang keras menyebutkan nama database asli/teknis (seperti "faceid_dev" atau nama teknis database lainnya) kepada pengguna dalam situasi dan konteks apa pun. Cukup sebut sebagai "database" atau "database sistem" jika perlu merujuk ke database.

## Skema Database
{$schema}

{$permissionBlock}

## Format Response
- Gunakan Markdown formatting (bold, list, table, code block)
- Untuk data tabel, gunakan markdown table
- Jika ada angka mata uang, format dengan "Rp" dan pemisah ribuan
PROMPT;
    }

    /**
     * Build a human-readable access control block for the AI based on user permissions.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    private function buildPermissionContextBlock(array $userContext): string
    {
        if (empty($userContext)) {
            return '## Konteks User & Hak Akses
Tidak ada informasi user. Tolak semua permintaan data.';
        }

        $userId = $userContext['id'] ?? 0;
        $name = $userContext['name'] ?? 'Unknown';
        $kodePegawai = $userContext['kode_pegawai'] ?? 'null';
        $roles = $userContext['roles'] ?? [];
        $permissions = $userContext['permissions'] ?? [];
        $permSet = array_flip($permissions);

        // Check specific administrative permissions
        $hasPegawaiList = isset($permSet['pegawai-list']);
        $hasUsersList = isset($permSet['users-list']);
        $hasCollectList = isset($permSet['collect-list']);
        $hasSpkList = isset($permSet['spk-list']);
        $hasInvoiceList = isset($permSet['invoice-list']);
        $hasTechnicianList = isset($permSet['technician-list']) || isset($permSet['technician-list-all']);
        $hasLaporanHarianList = isset($permSet['laporan-harian-list']);
        $hasRolesList = isset($permSet['roles-list']) || isset($permSet['permissions-list']);

        // Check approval/view-all permissions
        $hasAttendanceView = isset($permSet['attendance-view']) || isset($permSet['attendance-approve']);
        $hasDriverApprove = isset($permSet['driver-approve']) || isset($permSet['driver-list']) || isset($permSet['driver-list-jkt']) || isset($permSet['driver-list-medan']);
        $hasSalesApprove = isset($permSet['sales-approve']) || isset($permSet['sales-list']);
        $hasLeaveListAll = isset($permSet['leave-list-all']) || isset($permSet['leave-approval-center']);

        // Format the permissions description dynamically
        $pegawaiStatus = $hasPegawaiList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $userStatus = $hasUsersList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $collectStatus = $hasCollectList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $spkStatus = $hasSpkList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $invoiceStatus = $hasInvoiceList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $technicianStatus = $hasTechnicianList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $laporanHarianStatus = $hasLaporanHarianList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';
        $rolesStatus = $hasRolesList ? '✅ BOLEH diakses' : '❌ DILARANG diakses';

        // Row-level / Personal data status
        $attendanceScope = $hasAttendanceView ? 'Semua data absensi' : "Hanya data absensi milik sendiri (tb_attendance.kode_pegawai = '{$kodePegawai}' atau tb_attendance_out.kode_pegawai = '{$kodePegawai}')";
        $driverScope = $hasDriverApprove ? 'Semua laporan driver' : "Hanya laporan driver milik sendiri (tb_drivers.kode_pegawai = '{$kodePegawai}')";
        $salesScope = $hasSalesApprove ? 'Semua laporan sales' : "Hanya laporan sales milik sendiri (tb_sales.kode_pegawai = '{$kodePegawai}')";
        $leaveScope = $hasLeaveListAll ? 'Semua data cuti' : "Hanya data cuti milik sendiri (tb_leave_requests.user_id = {$userId} atau tb_leave_balances.user_id = {$userId})";
        $notificationScope = "Hanya notifikasi milik sendiri (notifications.notifiable_id = {$userId} AND notifications.notifiable_type = 'App\\\\Models\\\\User')";

        $rolesStr = implode(', ', $roles) ?: 'Tidak ada role';

        return <<<BLOCK
## Konteks User & Hak Akses

**User yang sedang chat:**
- Nama: {$name}
- User ID: {$userId}
- Kode Pegawai: {$kodePegawai}
- Role: {$rolesStr}

**Aturan Akses Tabel Terproteksi (Kategori Admin/Fitur):**
1. Data Pegawai (`tb_pegawai`, `tb_jabatan`, `tb_golongan`, `tb_division`, `tb_placement`): **{$pegawaiStatus}**
2. Akun User (`users`, `roles`, `permissions`): **{$userStatus}**
3. Laporan Kolektor (`tb_collect` dll): **{$collectStatus}**
4. SPK & Produksi (`tb_spk`, `tb_produksi` dll): **{$spkStatus}**
5. Invoice (`tb_invoice` dll): **{$invoiceStatus}**
6. Teknisi & VT (`tb_technician` dll): **{$technicianStatus}**
7. Laporan Harian (`laporan_harians` dll): **{$laporanHarianStatus}**
8. Roles & Permissions Spatie: **{$rolesStatus}**

**Aturan Ruang Lingkup Data (Scope / Row-Level Security):**
1. **Notifikasi (`notifications`)**: **{$notificationScope}** (Dilarang keras melihat notifikasi orang lain!)
2. **Absensi (`tb_attendance`, `tb_attendance_out`)**: **{$attendanceScope}**
3. **Laporan Driver (`tb_drivers`)**: **{$driverScope}**
4. **Laporan Sales (`tb_sales`)**: **{$salesScope}**
5. **Cuti (`tb_leave_requests`, `tb_leave_balances`)**: **{$leaveScope}**

> **PENTING UNTUK QUERY DATABASE (ROW-LEVEL SECURITY):**
> - Jika kategori tabel terproteksi di atas bertanda **❌ DILARANG diakses**, JANGAN lakukan query ke tabel-tabel tersebut. Tolak permintaan user dengan sopan dan jelaskan bahwa mereka tidak memiliki izin.
> - Jika mengakses data yang di-scope (seperti Absensi, Driver, Sales, Cuti, atau Notifikasi), kamu WAJIB menyertakan klausul `WHERE` yang membatasi query hanya ke data milik user saat ini (menggunakan `kode_pegawai = '{$kodePegawai}'` atau `user_id = {$userId}` atau `notifiable_id = {$userId}`) KECUALI jika keterangan di atas menyatakan **"Semua data"** (karena user memiliki permission approval/view-all).
> - Contoh: Jika user meminta absensi/laporan miliknya sendiri, atau notifikasi miliknya sendiri, query harus menyertakan filtering ID/Kode Pegawai milik user tersebut di atas.
BLOCK;
    }

    private function getDatabaseSchemaDescription(): string
    {
        return <<<'SCHEMA'
### Tabel Utama:
- **tb_pegawai**: Data pegawai (id, kode_pegawai, nik_pegawai, full_name, nick_name, no_telp, alamat, jabatan→tb_jabatan.id, golongan→tb_golongan.id, tgl_lahir, gender)
- **users**: Akun user (id, name, email, kode_pegawai→tb_pegawai.kode_pegawai, profile_pic, is_active). Terhubung ke roles via model_has_roles
- **tb_attendance**: Absensi masuk (id, kode_pegawai→tb_pegawai.kode_pegawai, waktuori, jam_masuk, longitude, latitude, status, verified, photoURL, position_status)
- **tb_attendance_out**: Absensi keluar (id, kode_pegawai→tb_pegawai.kode_pegawai, waktuori, jam_keluar, longitude, latitude, status, verified)
- **tb_jabatan**: Jabatan (id, nama_jabatan, divisi→tb_division.id, penempatan→tb_placement.id)
- **tb_golongan**: Golongan (id, nama_golongan, alias)
- **tb_division**: Divisi (id, kode_divisi, nama_divisi)
- **tb_placement**: Penempatan (id, kode_penempatan, penempatan, alamat, longitude, latitude, radius)
- **tb_jadwal**: Jadwal kerja (id, id_golongan→tb_golongan.id, hari, jam_masuk, jam_keluar, break_start, break_end)

### Piutang & Kolektor:
- **tb_collect**: Laporan kolektor (id, no_sr, bill_type, kode_pegawai→tb_pegawai.kode_pegawai, title, status[0=draft,1=approved,2=submitted,3=ditolak,4=revisi], payment_amount, assign_date)
- **tb_collect_tasks**: Piutang IDC Non PPN (id, no_sr, customer_name, total_bill, remaining_bill, assign_to, bill_status)
- **tb_collect_tasks_ppn**: Piutang IDC PPN (id, no_sr, sales_invoice, tax_invoice, customer_name, total_bill, remaining_bill, assign_to, bill_status)
- **tb_collect_idy_ppn**: Piutang IDY PPN (id, no_sr, sales_invoice, tax_invoice, customer_name, total_bill, remaining_bill, assign_to, bill_status)

### Driver & Sales:
- **tb_drivers**: Laporan driver (id, no_sr, kode_pegawai→tb_pegawai.kode_pegawai, title, lokasi, status[0=draft,1=submitted,2=approved,3=rejected], assign_date)
- **tb_sales**: Laporan sales (id, judul, kode_pegawai→tb_pegawai.kode_pegawai, pengajuan, jenis, status, catatan)

### SPK & Produksi:
- **tb_spk**: SPK utama (id, nomor_spk, nama_customer, alamat_kirim, nama_barang, berat_timbangan, jumlah, harga, ppn, total, tipe_timbangan, status_approval, deadline)
- **tb_produksi**: Produksi SPK (id, id_spk→tb_spk.id, assign_to→users.id, packing_list)
- **tb_purchasing_request**: Purchasing request (id, id_spk→tb_spk.id, kode_item, nama_item, qty, satuan)

### Invoice:
- **tb_invoice**: Invoice (id, nomor_btt, tgl_btt, nama_customer, tipe_invoice, status_pengiriman, tipe_tagihan)

### Cuti:
- **tb_leave_requests**: Pengajuan cuti (id, user_id→users.id, leave_type_id→tb_leave_types.id, start_date, end_date, total_days, reason, status[pending,approved_by_supervisor,approved,rejected,cancelled])
- **tb_leave_types**: Jenis cuti (id, name, code, default_days, requires_attachment)
- **tb_leave_balances**: Saldo cuti (id, user_id→users.id, year, total_quota, used_quota)

### Lainnya:
- **tb_technician**: Teknisi & VT (no_vt, kode_pegawai, status, keterangan)
- **tb_technician_points**: Poin teknisi (kode_pegawai, id_vt, poin, type, status)
- **tb_teams**: Tim (name, leader_id)
- **tb_team_members**: Anggota tim (team_id, kode_pegawai)
- **tb_holidays**: Libur nasional (date, name)
- **tb_log**: Log aktivitas (user_id, user_action, ip_address, user_agent)
- **roles & permissions**: via Spatie (roles, permissions, model_has_roles, model_has_permissions, role_has_permissions)

### Notifikasi & Sistem:
- **notifications**: Notifikasi sistem (id [UUID], type [nama class/tipe], notifiable_type [biasanya 'App\Models\User'], notifiable_id [ID User], data [JSON data, contains: 'message', 'button', 'created_at'], read_at [timestamp pembacaan, NULL jika belum dibaca], created_at, updated_at)
SCHEMA;
    }

    /**
     * @return array<int, array{functionDeclarations: array}>
     */
    private function buildTools(): array
    {
        return [
            [
                'type' => 'function',
                'name' => 'query_database',
                'description' => 'Execute a READ-ONLY SQL query against the system database. Only SELECT statements are allowed. Use this to search, filter, aggregate, or analyze data.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'sql' => [
                            'type' => 'string',
                            'description' => 'The SELECT SQL query to execute. Must start with SELECT. Max 50 rows (add LIMIT 50 if not present).',
                        ],
                    ],
                    'required' => ['sql'],
                ],
            ],
        ];
    }

    /**
     * @return array{success: bool, data?: array, error?: string, rows_count?: int}
     */
    private function executeFunction(string $name, array $args): array
    {
        if ($name !== 'query_database') {
            return ['success' => false, 'error' => "Unknown function: {$name}"];
        }

        $sql = trim($args['sql'] ?? '');

        // Validate SELECT only
        if (! preg_match('/^\s*SELECT\b/i', $sql)) {
            return ['success' => false, 'error' => 'Only SELECT queries are allowed'];
        }

        // Block dangerous keywords
        $blocked = ['INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'CREATE', 'TRUNCATE', 'REPLACE', 'GRANT', 'REVOKE', 'EXEC', 'EXECUTE', 'CALL'];
        foreach ($blocked as $keyword) {
            if (preg_match('/\b'.$keyword.'\b/i', $sql)) {
                return ['success' => false, 'error' => "Blocked keyword detected: {$keyword}"];
            }
        }

        // Enforce LIMIT
        if (! preg_match('/\bLIMIT\b/i', $sql)) {
            $sql = rtrim($sql, '; ').' LIMIT 50';
        }

        try {
            $results = DB::select($sql);
            $data = array_map(fn ($row) => (array) $row, $results);

            return [
                'success' => true,
                'data' => $data,
                'rows_count' => count($data),
            ];
        } catch (\Exception $e) {
            Log::warning('Chatbot SQL error', ['sql' => $sql, 'error' => $e->getMessage()]);

            return ['success' => false, 'error' => 'Query error: '.$e->getMessage()];
        }
    }

    /**
     * Generate a short title from a user message.
     */
    public function generateTitle(string $message): string
    {
        $clean = strip_tags($message);
        $clean = preg_replace('/\s+/', ' ', $clean);

        return mb_strlen($clean) > 50 ? mb_substr($clean, 0, 47).'...' : $clean;
    }
}
