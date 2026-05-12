<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('guest_id')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->string('payment_type',20)->nullable();
            $table->string('payment_status',20)->nullable();
            $table->longText('payment_details')->nullable();
            $table->double('grand_total')->nullable();
            $table->mediumText('code')->nullable();
            $table->integer('date')->nullable();
            $table->integer('viewed')->nullable();
            $table->boolean('upcoming')->nullable();
            $table->date('upcoming_date')->nullable();
            $table->string('confirm_by')->nullable();
            $table->date('confirm_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('medications');
    }
}
