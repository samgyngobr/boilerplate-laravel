<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkVersionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_version', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('active')->default(0);

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
        Schema::dropIfExists('sk_version');
    }
}
