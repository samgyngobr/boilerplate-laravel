<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_field_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');

            $table->bigInteger('id_sk_field')->unsigned();
            $table->foreign('id_sk_field')->references('id')->on('sk_field');

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
        Schema::dropIfExists('sk_field_options');
    }
}
