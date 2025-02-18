<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_measurementid_id')->nullable(false);
            $table->foreign('unit_measurementid_id', 'unit_measurementid_fk_10397224')->references('id')->on('unit_measurements');
        });
    }
}