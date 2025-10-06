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
        Schema::create('tb_big_event_participant_visitor', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('participant_id')
                ->constrained('tb_big_event_participant')
                ->cascadeOnDelete();
            $table->string('ip', 45)->nullable()->index();
            $table->string('ua', 255)->nullable();
            $table->timestamp('second_bucket')->nullable()->index();
            $table->unique(['ip', 'ua', 'second_bucket'], 'uniq_visit_guard');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_big_event_participant_visitor');
    }
};
