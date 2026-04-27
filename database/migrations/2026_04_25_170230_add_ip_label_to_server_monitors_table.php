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
        Schema::table('server_monitors', function (Blueprint $table) {
            $table->string('ip_label')->nullable()->after('api_url')->comment('Manual IP display override');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('server_monitors', function (Blueprint $table) {
            $table->dropColumn('ip_label');
        });
    }
};
