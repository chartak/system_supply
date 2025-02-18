<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWeekContractProductsTable extends Migration
{
    public function up()
    {
        Schema::table('week_contract_products', function (Blueprint $table) {
            $table->unsignedBigInteger('week_contract_id')->nullable();
            $table->foreign('week_contract_id', 'week_contract_fk_10420947')->references('id')->on('week_contracts');
        });
    }
}