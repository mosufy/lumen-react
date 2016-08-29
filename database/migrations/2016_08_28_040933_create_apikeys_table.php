<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApikeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apikeys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_key', 36)->default('');
            $table->text('api_secret')->nullable();
            $table->enum('status', ['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();

            $table->index(['api_key', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apikeys');
    }
}
