<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sk_field', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->integer('type'); // 1 text, 2 int, 3 double, 4 textarea, 5 select, 6 radio, 7 checkbox, 8 image, 9 upload, 10 date, 11 bool
            $table->tinyInteger('required')->default(0);
            $table->string('tip')->nullable();
            $table->string('additional')->nullable();
            $table->integer('validation')->nullable(); // 1=cpf 2=cnpj 3=email
            $table->integer('order');
            $table->tinyInteger('index')->default(0);

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
        Schema::dropIfExists('sk_field');
    }
}
