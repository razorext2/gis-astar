<?php

/** Goal: Validate AI-generated SQL queries against user permissions and row-level ownership rules, Caller: GeminiService, Deps: none */

namespace App\Services\Chatbot;

class ChatbotSqlGuard
{
    /** @var array<string, string[]> */
    private array $tableGroups = [
        'tb_attendance' => ['tb_attendance', 'tb_attendance_out', 'tb_attendance_inquiries', 'tb_overtime'],
        'tb_pegawai' => ['tb_pegawai', 'tb_pegawai_changes_histories', 'tb_jadwal'],
        'tb_jabatan' => ['tb_jabatan'],
        'tb_golongan' => ['tb_golongan'],
        'tb_division' => ['tb_division'],
        'tb_placement' => ['tb_placement'],
        'tb_spk' => ['tb_spk', 'tb_spk_delivery', 'tb_spk_histories', 'tb_spk_projects', 'tb_spk_receivable_histories'],
        'tb_spk_project' => ['tb_spk_project_assignments', 'tb_spk_project_daily_reports', 'tb_spk_project_hourly_reports', 'tb_spk_project_hourly_report_files'],
        'tb_produksi' => ['tb_produksi', 'tb_produksi_histories', 'tb_packing_list', 'tb_packing_list_kit'],
        'tb_purchasing_request' => ['tb_purchasing_request'],
        'tb_laporan_fondasi' => ['tb_laporan_fondasi'],
        'tb_invoice' => ['tb_invoice', 'tb_invoice_detail'],
        'tb_collect' => ['tb_collect', 'tb_photo_collect'],
        'tb_collect_tasks' => ['tb_collect_tasks'],
        'tb_collect_tasks_ppn' => ['tb_collect_tasks_ppn'],
        'tb_collect_idy_ppn' => ['tb_collect_idy_ppn'],
        'tb_drivers' => ['tb_drivers'],
        'tb_sales' => ['tb_sales'],
        'tb_technician' => ['tb_technician', 'tb_technician_points', 'tb_point_transactions', 'tb_point_transactions_view'],
        'tb_teams' => ['tb_teams', 'tb_team_members'],
        'tb_announcements' => ['tb_announcements', 'tb_announcement_reads'],
        'tb_leave' => ['tb_leave_balances', 'tb_leave_request_histories', 'tb_leave_requests', 'tb_leave_types'],
        'tb_holidays' => ['tb_holidays'],
        'tb_big_event' => ['tb_big_event', 'tb_big_event_participant', 'tb_big_event_participant_visitor'],
        'tb_backups' => ['tb_backups'],
        'tb_log' => ['tb_log'],
        'tb_chat' => ['tb_chat_conversations', 'tb_chat_messages'],
        'tb_vt' => ['tb_data_timbang_indodaya'],
        'notifications' => ['notifications'],
    ];

    /** @var array<string, list<string|null>> */
    private array $permissionsMapping = [
        'tb_attendance' => ['attendance-view'],
        'tb_attendance_out' => ['attendance-view'],
        'tb_attendance_inquiries' => ['attendance-view'],
        'tb_overtime' => ['attendance-view'],

        'tb_pegawai' => ['pegawai-list'],
        'tb_pegawai_changes_histories' => ['pegawai-list'],
        'tb_jadwal' => ['pegawai-list'],

        'tb_jabatan' => ['jabatan-list'],
        'tb_golongan' => ['golongan-list'],
        'tb_division' => ['divisi-list'],
        'tb_placement' => ['placement-list'],

        'tb_spk' => ['spk-list', 'spk-list-own-only'],
        'tb_spk_delivery' => ['spk-list', 'spk-list-own-only'],
        'tb_spk_histories' => ['spk-list', 'spk-list-own-only'],
        'tb_spk_projects' => ['spk-list', 'spk-list-own-only'],
        'tb_spk_receivable_histories' => ['spk-list', 'spk-list-own-only'],

        'tb_spk_project_assignments' => ['spk-list', 'technician-list', 'spk-list-own-only'],
        'tb_spk_project_daily_reports' => ['spk-list', 'technician-list', 'spk-list-own-only'],
        'tb_spk_project_hourly_reports' => ['spk-list', 'technician-list', 'spk-list-own-only'],
        'tb_spk_project_hourly_report_files' => ['spk-list', 'technician-list', 'spk-list-own-only'],

        'tb_produksi' => ['produksi-list'],
        'tb_produksi_histories' => ['produksi-list'],
        'tb_packing_list' => ['produksi-list'],
        'tb_packing_list_kit' => ['produksi-list'],

        'tb_purchasing_request' => ['purchasing-request-list'],
        'tb_laporan_fondasi' => ['laporan-fondasi-list'],

        'tb_invoice' => ['invoice-list'],
        'tb_invoice_detail' => ['invoice-list'],

        'tb_collect' => ['collect-list'],
        'tb_photo_collect' => ['collect-list'],
        'tb_collect_tasks' => ['collect-task-list'],
        'tb_collect_tasks_ppn' => ['collect-task-ppn-list'],
        'tb_collect_idy_ppn' => ['collect-idy-ppn-list'],

        'tb_drivers' => ['driver-list'],
        'tb_sales' => ['sales-list'],

        'tb_technician' => ['technician-list'],
        'tb_technician_points' => ['technician-list'],
        'tb_point_transactions' => ['technician-list'],
        'tb_point_transactions_view' => ['technician-list'],

        'tb_teams' => ['team-list'],
        'tb_team_members' => ['team-list'],

        'tb_announcements' => ['announcement-list'],
        'tb_announcement_reads' => ['announcement-list'],

        'tb_leave_balances' => ['leave-list-all'],
        'tb_leave_request_histories' => ['leave-list-all'],
        'tb_leave_requests' => ['leave-list-all'],
        'tb_leave_types' => [null],

        'tb_holidays' => ['holiday-list'],

        'tb_big_event' => ['event-manage'],
        'tb_big_event_participant' => ['event-manage'],
        'tb_big_event_participant_visitor' => ['event-manage'],

        'tb_backups' => ['backup-list'],
        'tb_log' => ['log-list'],

        'tb_chat_conversations' => ['ai-chatbot'],
        'tb_chat_messages' => ['ai-chatbot'],

        'tb_data_timbang_indodaya' => ['vt-list-all'],

        'notifications' => [null],
    ];

    /** @var list<string> */
    private array $blockedSystemTables = [
        'users', 'personal_access_tokens', 'failed_jobs', 'migrations', 'sessions', 'password_reset_tokens',
    ];

    /** @var list<string> */
    private array $blockedDmlKeywords = [
        'INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'CREATE', 'TRUNCATE', 'REPLACE', 'GRANT', 'REVOKE', 'EXEC', 'EXECUTE', 'CALL',
    ];

    private array $spkOwnershipTables = [
        'tb_spk', 'tb_spk_delivery', 'tb_spk_histories', 'tb_spk_projects',
        'tb_spk_project_assignments', 'tb_spk_project_daily_reports',
        'tb_spk_project_hourly_reports', 'tb_spk_project_hourly_report_files',
        'tb_spk_receivable_histories',
    ];

    private array $attendanceOwnershipTables = [
        'tb_attendance', 'tb_attendance_out', 'tb_attendance_inquiries', 'tb_overtime',
    ];

    /**
     * Check whether any of the given roles qualifies as admin/super-admin.
     *
     * @param  array<string>  $roles
     */
    public function isAdminRole(array $roles): bool
    {
        return in_array('super-admin', $roles, true)
            || in_array('admin', $roles, true)
            || in_array('Admin', $roles, true);
    }

    /**
     * Validate a SELECT SQL query against user context permissions and row-level ownership rules.
     *
     * @param  array{id: int, name: string, kode_pegawai: string|null, roles: array<string>, permissions: array<string>}  $userContext
     * @return array{allowed: bool, error?: string}
     */
    public function validateSqlAccess(string $sql, array $userContext): array
    {
        $permissions = $userContext['permissions'] ?? [];
        $roles = $userContext['roles'] ?? [];
        $isAdmin = $this->isAdminRole($roles);
        $userId = $userContext['id'] ?? 0;
        $kodePegawai = $userContext['kode_pegawai'] ?? null;

        if (! preg_match('/^\s*SELECT\b/i', $sql)) {
            return ['allowed' => false, 'error' => 'Only SELECT queries are allowed'];
        }

        foreach ($this->blockedDmlKeywords as $keyword) {
            if (preg_match('/\b'.$keyword.'\b/i', $sql)) {
                return ['allowed' => false, 'error' => "Blocked keyword detected: {$keyword}"];
            }
        }

        if ($isAdmin) {
            return ['allowed' => true];
        }

        foreach ($this->blockedSystemTables as $sysTable) {
            if (preg_match('/\b'.preg_quote($sysTable, '/').'\b/i', $sql)) {
                return ['allowed' => false, 'error' => "Access denied to system table: {$sysTable}"];
            }
        }

        $allAllowedTables = array_unique(array_map('strtolower', array_merge(...array_values($this->tableGroups))));

        preg_match_all('/\btb_[a-zA-Z0-9_]+\b/i', $sql, $wordMatches);
        foreach (array_unique(array_map('strtolower', $wordMatches[0] ?? [])) as $tbWord) {
            if (! in_array($tbWord, $allAllowedTables, true)) {
                return ['allowed' => false, 'error' => "Access denied to unknown table: {$tbWord}"];
            }
        }

        $queriedTables = [];
        foreach ($this->tableGroups as $group => $tables) {
            foreach ($tables as $table) {
                if (preg_match('/\b'.preg_quote($table, '/').'\b/i', $sql)) {
                    $queriedTables[$table] = $group;
                }
            }
        }

        foreach ($queriedTables as $table => $group) {
            $result = $this->checkTableAccess($table, $sql, $permissions, $userId, $kodePegawai);
            if (! $result['allowed']) {
                return $result;
            }
        }

        return ['allowed' => true];
    }

    /**
     * @param  array<string>  $permissions
     * @return array{allowed: bool, error?: string}
     */
    private function checkTableAccess(string $table, string $sql, array $permissions, int $userId, ?string $kodePegawai): array
    {
        if (in_array($table, $this->attendanceOwnershipTables, true) && ! in_array('attendance-view', $permissions, true)) {
            return $this->enforceKodePegawaiScope($table, $sql, $kodePegawai);
        }

        if (in_array($table, $this->spkOwnershipTables, true) && ! in_array('spk-list', $permissions, true)) {
            return $this->enforceSpkOwnershipScope($table, $sql, $userId);
        }

        if (in_array($table, ['tb_leave_requests', 'tb_leave_balances'], true) && ! in_array('leave-list-all', $permissions, true)) {
            return $this->enforceLeaveOwnershipScope($table, $sql, $permissions, $userId);
        }

        $requiredPermissions = $this->permissionsMapping[$table] ?? null;
        if ($requiredPermissions === null) {
            return ['allowed' => true];
        }

        foreach ($requiredPermissions as $perm) {
            if ($perm === null || in_array($perm, $permissions, true)) {
                return ['allowed' => true];
            }
        }

        $permString = implode(' or ', array_filter($requiredPermissions));

        return ['allowed' => false, 'error' => "Access denied. Missing permission: {$permString} for table: {$table}"];
    }

    /** @return array{allowed: bool, error?: string} */
    private function enforceKodePegawaiScope(string $table, string $sql, ?string $kodePegawai): array
    {
        if (empty($kodePegawai)) {
            return ['allowed' => false, 'error' => 'Employee code not found in user context to verify attendance ownership.'];
        }

        $escapedKode = preg_quote($kodePegawai, '/');
        if (! preg_match('/\bkode_pegawai\s*=\s*[\'"]'.$escapedKode.'[\'"]/i', $sql)) {
            return ['allowed' => false, 'error' => "Access denied to table {$table}. You can only query your own records using: kode_pegawai = '{$kodePegawai}'"];
        }

        return ['allowed' => true];
    }

    /** @return array{allowed: bool, error?: string} */
    private function enforceSpkOwnershipScope(string $table, string $sql, int $userId): array
    {
        if (! preg_match('/\b(?:added_by|assign_to|reassign_to)\s*=\s*'.$userId.'\b/i', $sql)) {
            return ['allowed' => false, 'error' => "Access denied to table {$table}. You can only query SPK/Project records assigned to or created by you. Please filter by: added_by = {$userId}, assign_to = {$userId}, or reassign_to = {$userId}"];
        }

        return ['allowed' => true];
    }

    /**
     * @param  array<string>  $permissions
     * @return array{allowed: bool, error?: string}
     */
    private function enforceLeaveOwnershipScope(string $table, string $sql, array $permissions, int $userId): array
    {
        if ($table === 'tb_leave_requests' && ! in_array('leave-list-own', $permissions, true)) {
            return ['allowed' => false, 'error' => "Access denied to table {$table}. Missing permission: leave-list-all or leave-list-own"];
        }

        if (! preg_match('/\buser_id\s*=\s*'.$userId.'\b/i', $sql)) {
            return ['allowed' => false, 'error' => "Access denied to table {$table}. You can only query your own leave records. Please ensure your query filters by: user_id = {$userId}"];
        }

        return ['allowed' => true];
    }
}
