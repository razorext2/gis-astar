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
        Schema::table('tb_spk_projects', function (Blueprint $table) {
            $table->boolean('extend_request') // request extend atau ngga
                ->default(false)
                ->after('customer_name');
            $table->date('extend_to') // mau diextend ke tanggal berapa
                ->nullable()
                ->after('extend_request');
            $table->foreignId('extend_request_by') // siapa yg minta extend
                ->nullable()
                ->after('extend_to')
                ->constrained('users')
                ->onDelete('cascade');
            $table->dateTime('extend_request_at') // kapan request extend diajukan
                ->nullable()
                ->after('extend_request_by');
            $table->text('extend_request_notes') // catatan extend
                ->nullable()
                ->after('extend_request_at');
            $table->enum('extend_request_status', ['pending', 'approved', 'rejected'])
                ->nullable()
                ->after('extend_request_notes');
            $table->dateTime('extend_request_validated_at') // kapan validasi extend
                ->nullable()
                ->after('extend_request_status');
            $table->string('extend_request_validated_notes') // catatan validasi extend
                ->nullable()
                ->after('extend_request_validated_at');
            $table->foreignId('extend_request_validated_by') // siapa yg validasi extend
                ->nullable()
                ->after('extend_request_validated_notes')
                ->constrained('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_spk_projects', function (Blueprint $table) {
            // drop foreign key dulu
            $table->dropForeign(['extend_request_by']);
            $table->dropForeign(['extend_request_validated_by']);

            // drop kolom
            $table->dropColumn([
                'extend_request',
                'extend_to',
                'extend_request_by',
                'extend_request_at',
                'extend_request_notes',
                'extend_request_status',
                'extend_request_validated_at',
                'extend_request_validated_notes',
                'extend_request_validated_by',
            ]);
        });
    }
};
