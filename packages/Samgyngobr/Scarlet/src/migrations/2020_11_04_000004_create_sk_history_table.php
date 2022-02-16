<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_history', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('current')->default(0);

            $table->bigInteger('id_sk_data')->unsigned();
            $table->foreign('id_sk_data')->references('id')->on('sk_data');

            $table->bigInteger('id_sk_version')->unsigned();
            $table->foreign('id_sk_version')->references('id')->on('sk_version');

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
        Schema::dropIfExists('sk_history');
    }
}
