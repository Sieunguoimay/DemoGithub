<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip',64);
            $table->string('fingerprint',256)->unique();
            $table->string('platform',256)->nullable();
            $table->string('city',32)->nullable();
            $table->string('country',32)->nullable();
            $table->string('isp',32)->nullable();
            $table->float('lon')->nullable();
            $table->float('lat')->nullable();
            $table->text('json')->nullable();
            $table->text('other_json')->nullable();
            $table->integer('access_count')->nullable();
            $table->boolean('belled')->default(false);
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
        Schema::dropIfExists('client_devices');
    }
}
