<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearContractProductsTable extends Migration
{
    public function up()
    {
        Schema::create('year_contract_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}