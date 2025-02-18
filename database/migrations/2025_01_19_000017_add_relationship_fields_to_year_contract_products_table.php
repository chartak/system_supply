<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToYearContractProductsTable extends Migration
{
    public function up()
    {
        Schema::table('year_contract_products', function (Blueprint $table) {
            $table->unsignedBigInteger('year_contractid_id')->nullable();
            $table->foreign('year_contractid_id', 'year_contractid_fk_10397231')->references('id')->on('year_contracts');
            $table->unsignedBigInteger('productid_id')->nullable();
            $table->foreign('productid_id', 'productid_fk_10397229')->references('id')->on('products');
        });
    }
}