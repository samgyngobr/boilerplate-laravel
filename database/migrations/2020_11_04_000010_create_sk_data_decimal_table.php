<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkDataDecimalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_data_decimal', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', 8, 2);

            $table->bigInteger('id_sk_history')->unsigned();
            $table->foreign('id_sk_history')->references('id')->on('sk_history');

            $table->bigInteger('id_sk_field')->unsigned();
            $table->foreign('id_sk_field')->references('id')->on('sk_field');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sk_data_decimal');
    }
}
