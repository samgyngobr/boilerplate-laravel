<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('legend');
            $table->tinyInteger('status')->default(0);

            $table->bigInteger('id_sk_data')->unsigned();
            $table->foreign('id_sk_data')->references('id')->on('sk_data');

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
        Schema::dropIfExists('sk_gallery');
    }
}
