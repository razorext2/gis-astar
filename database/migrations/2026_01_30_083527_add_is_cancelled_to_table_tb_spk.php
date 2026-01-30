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
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->boolean('is_cancelled')
                ->after('booked_by')
                ->default(false)
                ->index();
            $table->foreignId('cancel_request_by')
                ->nullable()
                ->after('is_cancelled')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->dateTime('cancel_request_at')
                ->nullable()
                ->after('cancel_request_by');
            $table->text('cancel_request_reason')
                ->nullable()
                ->after('cancel_request_at');
            $table->foreignId('cancel_request_validated_by')
                ->nullable()
                ->after('cancel_request_reason')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->dateTime('cancel_request_validated_at')
                ->nullable()
                ->after('cancel_request_validated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk', function (Blueprint $table) {
            $table->dropIndex(['is_cancelled']);
            $table->dropConstrainedForeignId('cancel_request_by');
            $table->dropConstrainedForeignId('cancel_request_validated_by');
            $table->dropColumn(['is_cancelled', 'cancel_request_at', 'cancel_request_validated_at', 'cancel_request_reason']);
        });
    }
};
