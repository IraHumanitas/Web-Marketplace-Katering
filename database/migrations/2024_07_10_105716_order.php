<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('customer')->onDelete('cascade');
            $table->foreignId('id_merchant')->constrained('merchant')->onDelete('cascade');
            $table->date('order_date');
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->string('status');
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
