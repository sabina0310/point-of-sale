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
        Schema::create('t_sale', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20);
            $table->integer('total_price')->nullable()->default(0);
            $table->integer('payment_amount')->nullable()->default(0);
            $table->integer('total_profit')->nullable()->default(0);
            $table->enum('status', ['success', 'pending'])->default('pending');
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sale');
    }
};
