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
        Schema::table('tb_big_event_participant_visitor', function (Blueprint $table) {
            $table->json('real_info')->nullable()->before('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_big_event_participant_visitor', function (Blueprint $table) {
            $table->dropColumn('real_info');
        });
    }
};
