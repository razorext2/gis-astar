<?php

/** Goal: Create tb_pegawai_changes_histories table for auditing employee data changes, Caller: php artisan migrate, Deps: Schema */

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
        Schema::create('tb_pegawai_changes_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('tb_pegawai')->cascadeOnDelete();
            $table->string('field_name');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('alasan')->nullable();
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pegawai_changes_histories');
    }
};
