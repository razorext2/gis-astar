<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_leave_types', function (Blueprint $table) {
            $table->boolean('use_calendar_days')->default(false)->after('requires_attachment');
        });

        // Set Cuti Melahirkan (CT-LAHIR) to use calendar days
        \App\Models\LeaveRequest\LeaveType::where('code', 'CT-LAHIR')
            ->update(['use_calendar_days' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_leave_types', function (Blueprint $table) {
            $table->dropColumn('use_calendar_days');
        });
    }
};
