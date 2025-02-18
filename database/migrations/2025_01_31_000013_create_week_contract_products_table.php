<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekContractProductsTable extends Migration
{
    public function up()
    {
        Schema::create('week_contract_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('quantity', 15, 2);
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}