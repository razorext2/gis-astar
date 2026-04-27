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
        Schema::create('server_monitor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_monitor_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['online', 'offline']);
            $table->unsignedInteger('response_time_ms')->nullable()->comment('Null jika offline/timeout');
            $table->string('note')->nullable()->comment('Error message jika offline');
            $table->timestamp('logged_at');
            $table->index(['server_monitor_id', 'logged_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_monitor_logs');
    }
};
