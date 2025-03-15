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
        Schema::table('tb_drivers', function (Blueprint $table) {
            $table->integer('total_revision')->default(0)->after('validate_by');
            $table->string('revised_by', 100)->nullable()->after('total_revision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_drivers', function (Blueprint $table) {
            //
        });
    }
};
