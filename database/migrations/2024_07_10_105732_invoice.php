<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_order')
                  ->constrained('order')
                  ->onDelete('cascade');
            $table->foreignId('id_customer')
                  ->constrained('customer')
                  ->onDelete('cascade');
            $table->date('date');
            $table->date('due_date');
            $table->decimal('total_amount', 10, 2);
            $table->string('status');
            $table->string('invoice_number');
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
