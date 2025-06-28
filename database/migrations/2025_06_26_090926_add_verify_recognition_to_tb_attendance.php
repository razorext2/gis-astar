<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->boolean('verified')->default(false)->nullable()->after('photoURL');
            $table->string('distance')->nullable()->after('verified');
            $table->string('verified_by')->nullable()->after('distance');
            $table->text('keterangan')->nullable()->after('verified_by');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->boolean('verified')->default(false)->nullable()->after('photoURL');
            $table->string('distance')->nullable()->after('verified');
            $table->string('verified_by')->nullable()->after('distance');
            $table->text('keterangan')->nullable()->after('verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_attendance', function (Blueprint $table) {
            $table->dropColumn('verified');
            $table->dropColumn('distance');
            $table->dropColumn('verified_by');
            $table->dropColumn('keterangan');
        });

        Schema::table('tb_attendance_out', function (Blueprint $table) {
            $table->dropColumn('verified');
            $table->dropColumn('distance');
            $table->dropColumn('verified_by');
            $table->dropColumn('keterangan');
        });
    }
};
