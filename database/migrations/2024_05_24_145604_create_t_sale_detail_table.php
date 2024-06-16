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
        Schema::create('t_sale_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->foreign('sale_id')->references('id')->on('t_sale');
            $table->integer('product_id');
            $table->foreign('product_id')->references('id')->on('m_product');
            $table->integer('quantity');
            $table->integer('total_price');
            $table->integer('total_profit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sale_detail');
    }
};
