<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekContractYearContractPivotTable extends Migration
{
    public function up()
    {
        Schema::create('week_contract_year_contract', function (Blueprint $table) {
            $table->unsignedBigInteger('week_contract_id');
            $table->foreign('week_contract_id', 'week_contract_id_fk_10420938')->references('id')->on('week_contracts')->onDelete('cascade');
            $table->unsignedBigInteger('year_contract_id');
            $table->foreign('year_contract_id', 'year_contract_id_fk_10420938')->references('id')->on('year_contracts')->onDelete('cascade');
        });
    }
}