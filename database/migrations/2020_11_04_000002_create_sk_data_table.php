<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_data', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->tinyInteger('deleted')->default(0);
            $table->tinyInteger('published')->default(0);

            $table->bigInteger('id_sk_area')->unsigned();
            $table->foreign('id_sk_area')->references('id')->on('sk_area');

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
        Schema::dropIfExists('sk_data');
    }
}
