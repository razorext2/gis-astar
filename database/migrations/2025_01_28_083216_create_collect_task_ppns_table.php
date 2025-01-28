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
        Schema::create('tb_collect_tasks_ppn', function (Blueprint $table) {
            $table->id();
            $table->string('no_sr', 32)->index()->unique();
            $table->string('collect_type', 32)->index();
            $table->string('sr_type', 32)->nullable();
            $table->string('sr_date', 64);
            $table->string('customer_name', 128);
            $table->string('customer_recipient', 128)->nullable();
            $table->string('customer_address', 128)->nullable();
            $table->string('customer_telp', 128)->nullable();
            $table->integer('customer_fax')->nullable();
            $table->string('shipping_address')->nullable();
            $table->float('total_bill')->nullable();
            $table->float('remaining_bill')->nullable();
            $table->string('assign_by', 20)->nullable();
            $table->string('assign_to', 20)->nullable();
            $table->date('assign_date')->nullable();
            $table->smallInteger('bill_status')->nullable();
            $table->string('validate_by', 32)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_task_ppns');
    }
};
