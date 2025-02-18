<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekContractProductYearContractProductPivotTable extends Migration
{
    public function up()
    {
        Schema::create('week_contract_product_year_contract_product', function (Blueprint $table) {
            $table->unsignedBigInteger('week_contract_product_id');
            $table->foreign('week_contract_product_id', 'week_contract_product_id_fk_10420949')->references('id')->on('week_contract_products')->onDelete('cascade');
            $table->unsignedBigInteger('year_contract_product_id');
            $table->foreign('year_contract_product_id', 'year_contract_product_id_fk_10420949')->references('id')->on('year_contract_products')->onDelete('cascade');
        });
    }
}