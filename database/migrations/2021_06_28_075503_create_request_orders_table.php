<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_orders', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name')->nullable();
            $table->string('phone')->nullable();
            $table->longText('medicine_details')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('read')->nullable();
            $table->string('remark')->nullable();
            $table->string('comment')->nullable();
            $table->string('redate')->nullable();
            $table->boolean('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('request_orders');
    }
}
