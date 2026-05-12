<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
            $table->string('source')->nullable();
            $table->bigInteger('views')->nullable();
            $table->boolean('status')->nullable();
            $table->string('meta_tag')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('tags')->nullable();
            $table->string('create_by')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
