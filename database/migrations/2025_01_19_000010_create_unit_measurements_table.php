<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitMeasurementsTable extends Migration
{
    public function up()
    {
        Schema::create('unit_measurements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit_of_measurement');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}