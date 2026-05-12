<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medication_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('medication_id')->unsigned()->nullable();
            $table->foreign('medication_id')->references('id')->on('medications')->onDelete('cascade');
            $table->integer('seller_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->longText('variation')->nullable();
            $table->string('price')->nullable();
            $table->string('tax')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medication_details');
    }
}
