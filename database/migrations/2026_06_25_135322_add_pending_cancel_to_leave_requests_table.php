<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE tb_leave_requests MODIFY COLUMN status ENUM('draft', 'pending_backup', 'pending_spv', 'pending_hrd', 'pending_management', 'approved', 'rejected', 'auto_reject', 'delayed', 'cancelled', 'pending_cancel') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting enum changes might be tricky if there are rows with 'pending_cancel', 
        // but we'll try to revert back to the previous enum state.
        DB::statement("ALTER TABLE tb_leave_requests MODIFY COLUMN status ENUM('draft', 'pending_backup', 'pending_spv', 'pending_hrd', 'pending_management', 'approved', 'rejected', 'auto_reject', 'delayed', 'cancelled') DEFAULT 'draft'");
    }
};
