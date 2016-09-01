<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesslogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesslogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->enum('owner_type', ['client', 'user'])->default('user');
            $table->integer('owner_id')->nullable()->unsigned();
            $table->string('endpoint')->default('');
            $table->string('method', 8)->default('');
            $table->string('status_code', 3)->default('');
            $table->longText('response')->default('');
            $table->string('access_token', 40)->default('');
            $table->string('ip_address', 32)->default('');
            $table->string('ip_country', 64)->default('');
            $table->string('ip_country_code', 2)->default('');
            $table->string('hostname')->default('');
            $table->string('platform', 16)->default('');
            $table->string('device', 32)->default('');
            $table->string('browser', 50)->default('');
            $table->string('browser_version', 50)->default('');
            $table->string('browser_language', 50)->default('');
            $table->string('os', 50)->default('');
            $table->string('os_version', 50)->default('');
            $table->timestamps();

            $table->index(['client_id', 'owner_type', 'owner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accesslogs');
    }
}
