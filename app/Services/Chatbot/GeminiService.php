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
     * @param  array{name: string, roles: array<string>, permissions: array<string>}  $userContext
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
     * @param  array{name: string, roles: array<string>, permissions: array<string>}  $userContext
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
1. **Pencarian Data** — Kamu bisa query database `faceid_dev` (READ-ONLY) untuk membantu user mencari data pegawai, absensi, piutang, SPK, driver, sales, invoice, dll.
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

## Skema Database (faceid_dev)
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
     * @param  array{name: string, roles: array<string>, permissions: array<string>}  $userContext
     */
    private function buildPermissionContextBlock(array $userContext): string
    {
        if (empty($userContext)) {
            return '## Konteks User & Hak Akses
Tidak ada informasi user. Tolak semua permintaan data sensitif.';
        }

        $userId = $userContext['id'] ?? 0;
        $name = $userContext['name'] ?? 'Unknown';
        $roles = $userContext['roles'] ?? [];
        $permissions = $userContext['permissions'] ?? [];
        $permSet = array_flip($permissions);

        /** @var array<string, array{label: string, tables: string, perms: string[]}> */
        $accessMap = [
            'data_pegawai' => [
                'label' => 'Data Pegawai (tb_pegawai)',
                'tables' => 'tb_pegawai, tb_jabatan, tb_golongan, tb_division, tb_placement',
                'perms' => ['pegawai-list'],
            ],
            'data_user' => [
                'label' => 'Akun User (users, roles)',
                'tables' => 'users, roles, permissions, model_has_roles',
                'perms' => ['users-list'],
            ],
            'data_absensi' => [
                'label' => 'Absensi (tb_attendance, tb_attendance_out)',
                'tables' => 'tb_attendance, tb_attendance_out',
                'perms' => ['attendance-view'],
            ],
            'data_piutang_kolektor' => [
                'label' => 'Piutang Kolektor (tb_collect, tb_collect_tasks, tb_collect_tasks_ppn, tb_collect_idy_ppn)',
                'tables' => 'tb_collect, tb_collect_tasks, tb_collect_tasks_ppn, tb_collect_idy_ppn',
                'perms' => ['collect-list'],
            ],
            'data_spk' => [
                'label' => 'SPK & Produksi (tb_spk, tb_produksi, tb_purchasing_request)',
                'tables' => 'tb_spk, tb_produksi, tb_purchasing_request',
                'perms' => ['spk-list'],
            ],
            'data_invoice' => [
                'label' => 'Invoice (tb_invoice, tb_invoice_detail)',
                'tables' => 'tb_invoice, tb_invoice_detail',
                'perms' => ['invoice-list'],
            ],
            'data_driver' => [
                'label' => 'Driver (tb_drivers)',
                'tables' => 'tb_drivers',
                'perms' => ['driver-list', 'driver-list-jkt', 'driver-list-medan'],
            ],
            'data_sales' => [
                'label' => 'Sales (tb_sales)',
                'tables' => 'tb_sales',
                'perms' => ['sales-list'],
            ],
            'data_cuti_semua' => [
                'label' => 'Semua Data Cuti (tb_leave_requests)',
                'tables' => 'tb_leave_requests, tb_leave_types, tb_leave_balances',
                'perms' => ['leave-list-all'],
            ],
            'data_cuti_sendiri' => [
                'label' => 'Cuti Milik Sendiri (tb_leave_requests WHERE user_id = ID user saat ini)',
                'tables' => 'tb_leave_requests, tb_leave_types, tb_leave_balances',
                'perms' => ['leave-list-own'],
            ],
            'data_teknisi' => [
                'label' => 'Teknisi & VT (tb_technician, tb_technician_points)',
                'tables' => 'tb_technician, tb_technician_points',
                'perms' => ['technician-list', 'technician-list-all'],
            ],
            'data_laporan_harian' => [
                'label' => 'Laporan Harian (laporan_harians)',
                'tables' => 'laporan_harians, laporan_harian_details',
                'perms' => ['laporan-harian-list'],
            ],
            'data_roles_permissions' => [
                'label' => 'Roles & Permissions (roles, permissions)',
                'tables' => 'roles, permissions, model_has_roles, role_has_permissions',
                'perms' => ['roles-list', 'permissions-list'],
            ],
        ];

        $allowedAccess = [];
        $deniedAccess = [];

        foreach ($accessMap as $key => $rule) {
            $hasAccess = false;
            foreach ($rule['perms'] as $perm) {
                if (isset($permSet[$perm])) {
                    $hasAccess = true;
                    break;
                }
            }

            if ($hasAccess) {
                $allowedAccess[] = "- ✅ **{$rule['label']}**";
            } else {
                $deniedAccess[] = "- ❌ **{$rule['label']}** — DILARANG DIAKSES";
            }
        }

        $rolesStr = implode(', ', $roles) ?: 'Tidak ada role';
        $allowedStr = implode("\n", $allowedAccess) ?: '- (tidak ada akses data)';
        $deniedStr = implode("\n", $deniedAccess) ?: '- (tidak ada yang diblokir)';

        return <<<BLOCK
## Konteks User & Hak Akses

**User yang sedang chat:**
- Nama: {$name}
- User ID: {$userId}
- Role: {$rolesStr}

**Data yang BOLEH diakses:**
{$allowedStr}

**Data yang TIDAK BOLEH diakses (tolak permintaan ini):**
{$deniedStr}

> **INSTRUKSI KRITIS:** Jika user meminta data dari kategori yang DILARANG, JANGAN query database. Langsung balas: "Maaf, kamu tidak memiliki izin untuk mengakses [nama data]. Hubungi administrator untuk mendapatkan akses."
> Jika user meminta cuti milik sendiri (leave-list-own), pastikan query selalu menyertakan `WHERE user_id = [id user saat ini]` dan JANGAN tampilkan data cuti orang lain.
BLOCK;
    }

    private function getDatabaseSchemaDescription(): string
    {
        return <<<'SCHEMA'
### Tabel Utama:
- **tb_pegawai**: Data pegawai (kode_pegawai, nik_pegawai, full_name, nick_name, no_telp, alamat, jabatan→tb_jabatan, golongan→tb_golongan, tgl_lahir, gender)
- **users**: Akun user (name, email, kode_pegawai→tb_pegawai, profile_pic, is_active). Terhubung ke roles via model_has_roles
- **tb_attendance**: Absensi masuk (kode_pegawai→tb_pegawai, waktuori, jam_masuk, longitude, latitude, status, verified, photoURL, position_status)
- **tb_attendance_out**: Absensi keluar (kode_pegawai→tb_pegawai, waktuori, jam_keluar, longitude, latitude, status, verified)
- **tb_jabatan**: Jabatan (nama_jabatan, divisi→tb_division, penempatan→tb_placement)
- **tb_golongan**: Golongan (nama_golongan, alias)
- **tb_division**: Divisi (kode_divisi, nama_divisi)
- **tb_placement**: Penempatan (kode_penempatan, penempatan, alamat, longitude, latitude, radius)
- **tb_jadwal**: Jadwal kerja (id_golongan→tb_golongan, hari, jam_masuk, jam_keluar, break_start, break_end)

### Piutang & Kolektor:
- **tb_collect**: Laporan kolektor (no_sr, bill_type, kode_pegawai→tb_pegawai, title, status[0=draft,1=approved,2=submitted,3=ditolak,4=revisi], payment_amount, assign_date)
- **tb_collect_tasks**: Piutang IDC Non PPN (no_sr, customer_name, total_bill, remaining_bill, assign_to, bill_status)
- **tb_collect_tasks_ppn**: Piutang IDC PPN (no_sr, sales_invoice, tax_invoice, customer_name, total_bill, remaining_bill, assign_to, bill_status)
- **tb_collect_idy_ppn**: Piutang IDY PPN (no_sr, sales_invoice, tax_invoice, customer_name, total_bill, remaining_bill, assign_to, bill_status)

### Driver & Sales:
- **tb_drivers**: Laporan driver (no_sr, kode_pegawai→tb_pegawai, title, lokasi, status[0=draft,1=submitted,2=approved,3=rejected], assign_date)
- **tb_sales**: Laporan sales (judul, kode_pegawai→tb_pegawai, pengajuan, jenis, status, catatan)

### SPK & Produksi:
- **tb_spk**: SPK utama (nomor_spk, nama_customer, alamat_kirim, nama_barang, berat_timbangan, jumlah, harga, ppn, total, tipe_timbangan, status_approval, deadline)
- **tb_produksi**: Produksi SPK (id_spk→tb_spk, assign_to→users, packing_list)
- **tb_purchasing_request**: Purchasing request (id_spk→tb_spk, kode_item, nama_item, qty, satuan)

### Invoice:
- **tb_invoice**: Invoice (nomor_btt, tgl_btt, nama_customer, tipe_invoice, status_pengiriman, tipe_tagihan)

### Cuti:
- **tb_leave_requests**: Pengajuan cuti (user_id→users, leave_type_id→tb_leave_types, start_date, end_date, total_days, reason, status[pending,approved_by_supervisor,approved,rejected,cancelled])
- **tb_leave_types**: Jenis cuti (name, code, default_days, requires_attachment)
- **tb_leave_balances**: Saldo cuti (user_id→users, year, total_quota, used_quota)

### Lainnya:
- **tb_technician**: Teknisi & VT (no_vt, kode_pegawai, status, keterangan)
- **tb_technician_points**: Poin teknisi (kode_pegawai, id_vt, poin, type, status)
- **tb_teams**: Tim (name, leader_id)
- **tb_team_members**: Anggota tim (team_id, kode_pegawai)
- **tb_holidays**: Libur nasional (date, name)
- **tb_log**: Log aktivitas (user_id, user_action, ip_address, user_agent)
- **roles & permissions**: via Spatie (roles, permissions, model_has_roles, model_has_permissions, role_has_permissions)
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
                'description' => 'Execute a READ-ONLY SQL query against the faceid_dev database. Only SELECT statements are allowed. Use this to search, filter, aggregate, or analyze data.',
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
