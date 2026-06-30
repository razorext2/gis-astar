<?php

/** Goal: Assemble the Gemini system prompt from modular MD files and user context, Caller: GeminiService, Deps: ChatbotSqlGuard, resources/prompts/chatbot/ */

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Log;

class ChatbotPromptBuilder
{
    private const PROMPT_BASE_PATH = 'prompts/chatbot';

    private const VALID_PERSONAS = ['professional', 'cheerful', 'strict'];

    public function __construct(private readonly ChatbotSqlGuard $sqlGuard) {}

    /**
     * Build the Gemini tools declaration array.
     *
     * @return array<int, array<string, mixed>>
     */
    public function buildTools(): array
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
            [
                'type' => 'function',
                'name' => 'export_data_file',
                'description' => 'Export a dataset to a downloadable Excel (.xlsx) or PDF (.pdf) file. Use this when the user explicitly requests to download, export, or save data as an Excel or PDF file.',
                'parameters' => [
                    'type' => 'object',
                    'properties' => [
                        'data_json' => [
                            'type' => 'string',
                            'description' => 'JSON string of an array of objects representing the rows to export.',
                        ],
                        'format' => [
                            'type' => 'string',
                            'description' => 'The file format to export. Must be either "xlsx" or "pdf".',
                            'enum' => ['xlsx', 'pdf'],
                        ],
                        'title' => [
                            'type' => 'string',
                            'description' => 'The title or filename of the exported report.',
                        ],
                    ],
                    'required' => ['data_json', 'format', 'title'],
                ],
            ],
        ];
    }

    /**
     * Build the full system instruction by loading modular MD files and replacing placeholders.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    public function buildSystemInstruction(array $userContext = [], string $persona = 'professional'): string
    {
        $currentTime = now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i:s');
        $baseUrl = rtrim(config('app.url', 'https://indodacin.dev'), '/');
        $validatedPersona = in_array($persona, self::VALID_PERSONAS, true) ? $persona : 'professional';

        $template = $this->loadPromptFile('system.md');
        $schema = $this->loadPromptFile('schema.md');
        $navigation = $this->loadPromptFile('navigation.md');
        $personaContent = $this->loadPromptFile("personas/{$validatedPersona}.md");
        $permissionBlock = $this->buildPermissionContextBlock($userContext);

        return str_replace(
            ['{{ currentTime }}', '{{ baseUrl }}', '{{ schema }}', '{{ navigation }}', '{{ persona }}', '{{ permissionBlock }}'],
            [$currentTime, $baseUrl, $schema, $navigation, $personaContent, $permissionBlock],
            $template
        );
    }

    /**
     * Build the permission context block injected into the system prompt.
     *
     * Maps application Spatie permissions to table-level access rules so the AI
     * knows which data categories the current user can query.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     */
    public function buildPermissionContextBlock(array $userContext): string
    {
        $permissions = $userContext['permissions'] ?? [];
        $roles = $userContext['roles'] ?? [];
        $isAdmin = $this->sqlGuard->isAdminRole($roles);
        $userId = $userContext['id'] ?? 0;
        $kodePegawai = $userContext['kode_pegawai'] ?? null;

        /**
         * Table groups MUST mirror the permission mapping in ChatbotSqlGuard exactly.
         * Any mismatch causes AI to report incorrect access to users.
         *
         * @var array<string, array{permission: string|null}> $tableGroups
         */
        $tableGroups = [
            'Attendance Data (tb_attendance, tb_attendance_out, tb_attendance_inquiries, tb_overtime)' => ['permission' => 'attendance-view'],
            'Employee Data (tb_pegawai, tb_pegawai_changes_histories, tb_jadwal)' => ['permission' => 'pegawai-list'],
            'Job Titles (tb_jabatan)' => ['permission' => 'jabatan-list'],
            'Grade / Golongan (tb_golongan)' => ['permission' => 'golongan-list'],
            'Divisions (tb_division)' => ['permission' => 'divisi-list'],
            'Placements (tb_placement)' => ['permission' => 'placement-list'],
            'SPK / Work Orders (tb_spk, tb_spk_delivery, tb_spk_histories, tb_spk_projects, tb_spk_receivable_histories)' => ['permission' => 'spk-list'],
            'Production (tb_produksi, tb_produksi_histories, tb_packing_list, tb_packing_list_kit)' => ['permission' => 'produksi-list'],
            'Purchasing Requests (tb_purchasing_request)' => ['permission' => 'purchasing-request-list'],
            'Foundation Reports (tb_laporan_fondasi)' => ['permission' => 'laporan-fondasi-list'],
            'Invoices (tb_invoice, tb_invoice_detail)' => ['permission' => 'invoice-list'],
            'Collections (tb_collect, tb_photo_collect)' => ['permission' => 'collect-list'],
            'Collection Tasks (tb_collect_tasks)' => ['permission' => 'collect-task-list'],
            'Collection Tasks PPN (tb_collect_tasks_ppn)' => ['permission' => 'collect-task-ppn-list'],
            'IDY PPN Collections (tb_collect_idy_ppn)' => ['permission' => 'collect-idy-ppn-list'],
            'Driver Reports (tb_drivers)' => ['permission' => 'driver-list'],
            'Sales Reports (tb_sales)' => ['permission' => 'sales-list'],
            'Technician & Points (tb_technician, tb_technician_points, tb_point_transactions, tb_point_transactions_view, tb_spk_project_assignments, tb_spk_project_daily_reports, tb_spk_project_hourly_reports, tb_spk_project_hourly_report_files)' => ['permission' => 'technician-list'],
            'Teams (tb_teams, tb_team_members)' => ['permission' => 'team-list'],
            'System Announcements (tb_announcements, tb_announcement_reads)' => ['permission' => 'announcement-list'],
            'Leave Management (tb_leave_balances, tb_leave_request_histories, tb_leave_requests)' => ['permission' => 'leave-list-all'],
            'Leave Types (tb_leave_types)' => ['permission' => null],
            'Public Holidays (tb_holidays)' => ['permission' => 'holiday-list'],
            'Event Management (tb_big_event, tb_big_event_participant, tb_big_event_participant_visitor)' => ['permission' => 'event-manage'],
            'System Backups (tb_backups)' => ['permission' => 'backup-list'],
            'System Logs (tb_log)' => ['permission' => 'log-list'],
            'AI Chat History (tb_chat_conversations, tb_chat_messages)' => ['permission' => 'ai-chatbot'],
            'Vehicle Weighing (tb_data_timbang_indodaya)' => ['permission' => 'vt-list-all'],
            'Notifications (notifications)' => ['permission' => null],
        ];

        $lines = [
            '## User Context & Access Rights',
            '',
            "- **User ID**: {$userId}",
            '- **Name**: '.($userContext['name'] ?? 'Unknown'),
            '- **Kode Pegawai**: '.($kodePegawai ?? 'N/A'),
            '- **Roles**: '.(! empty($roles) ? implode(', ', $roles) : 'none'),
            '',
            '### Table Access Control',
            '',
        ];

        foreach ($tableGroups as $label => $config) {
            $granted = $isAdmin || $config['permission'] === null || in_array($config['permission'], $permissions, true);
            $icon = $granted ? '✅' : '❌';
            $status = $granted ? 'ACCESS GRANTED' : 'ACCESS DENIED';
            $lines[] = "- {$icon} **{$label}** — {$status}";
        }

        $lines[] = '';
        $lines[] = '### Data Scope Rules';
        $lines[] = '';

        if ($isAdmin) {
            $lines[] = '- You have **admin access** — you may query ALL rows across all accessible tables without user-level filtering.';
        } else {
            $lines[] = "- **Attendance/Overtime**: You may only view attendance records where `kode_pegawai = '{$kodePegawai}'` unless you have the `attendance-view` permission, in which case you may view all employees' attendance.";
            $lines[] = "- **Leave Requests**: You may only view leave records where `user_id = {$userId}` unless you have the `leave-list-all` permission, in which case you may view all employees' leaves.";
            $lines[] = '- **Notifications**: Only query notifications where `notifiable_id = '.$userId."'.";
            $lines[] = '- For all other permitted tables: you may view all data within that category, but NEVER expose salary, password, token, or credential fields.';
        }

        return implode("\n", $lines);
    }

    private function loadPromptFile(string $relativePath): string
    {
        $path = resource_path(self::PROMPT_BASE_PATH.'/'.$relativePath);

        if (! file_exists($path)) {
            Log::error('Chatbot prompt file not found', ['path' => $path]);

            return '';
        }

        return file_get_contents($path);
    }
}
