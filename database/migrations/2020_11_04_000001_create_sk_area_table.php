<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_area', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->string('url');
            $table->tinyInteger('multiple')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('gallery')->default(0);

            $table->bigInteger('id_sk_area')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::table('sk_area', function (Blueprint $table) {
            $table->foreign('id_sk_area')->references('id')->on('sk_area')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sk_area');
        Schema::enableForeignKeyConstraints();
    }
}
