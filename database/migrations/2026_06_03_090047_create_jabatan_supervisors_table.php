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
        if (!Schema::hasTable('jabatan_supervisors')) {
            Schema::create('jabatan_supervisors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('jabatan_id')->constrained('tb_jabatan')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->timestamps();
            });
        }

        Schema::table('tb_jabatan', function (Blueprint $table) {
            if (Schema::hasColumn('tb_jabatan', 'supervisor_id')) {
                // Drop foreign key first if it exists
                try {
                    $table->dropForeign(['supervisor_id']);
                } catch (\Exception $e) {
                    // Ignore if no foreign key exists
                }
                $table->dropColumn('supervisor_id');
            }
        });

        Schema::table('tb_placement', function (Blueprint $table) {
            if (Schema::hasColumn('tb_placement', 'manager_id')) {
                try {
                    $table->dropForeign(['manager_id']);
                } catch (\Exception $e) {
                    // Ignore if no foreign key exists
                }
                $table->dropColumn('manager_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_placement', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_placement', 'manager_id')) {
                $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('tb_jabatan', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_jabatan', 'supervisor_id')) {
                $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });

        Schema::dropIfExists('jabatan_supervisors');
    }
};
