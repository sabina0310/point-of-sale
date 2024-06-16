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
        Schema::create('m_product', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('category_id');
            $table->foreign('category_id')->references('id')->on('m_category');
            $table->string('purchase_unit');
            $table->integer('purchase_price');
            $table->string('quantity_per_purchase_unit');
            $table->integer('price_per_purchase_item');
            $table->string('sale_unit');
            $table->integer('sale_price');
            $table->integer('stock');
            $table->timestamps();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_product');
    }
};
