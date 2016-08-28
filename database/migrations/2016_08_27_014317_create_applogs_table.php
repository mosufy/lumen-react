<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 50)->nullable();
            $table->string('classname', 255)->nullable();
            $table->string('traitname', 255)->nullable();
            $table->string('functionname', 255)->nullable();
            $table->string('filename', 255)->nullable();
            $table->integer('linenumber')->nullable();
            $table->longText('message')->nullable();
            $table->string('code', 50)->nullable();
            $table->longText('details')->nullable();
            $table->string('ipaddr', 32)->nullable();
            $table->integer('createdby_user_id')->unsigned()->nullable();
            $table->string('createdby', 50)->nullable();
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
        Schema::drop('applogs');
    }
}
