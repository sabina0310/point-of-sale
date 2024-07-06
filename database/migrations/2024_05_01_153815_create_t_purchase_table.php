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
        Schema::create('t_purchase', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number', 20);
            $table->integer('product_id');
            $table->foreign('product_id')->references('id')->on('m_product');
            $table->integer('purchase_quantity');
            $table->integer('purchase_stock');
            $table->integer('total_price');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_purchase');
    }
};
