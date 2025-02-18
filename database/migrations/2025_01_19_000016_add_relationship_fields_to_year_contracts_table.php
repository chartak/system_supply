<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToYearContractsTable extends Migration
{
    public function up()
    {
        Schema::table('year_contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('customerid_id')->nullable(false);
            $table->foreign('customerid_id', 'customerid_fk_10397203')->references('id')->on('user_infos');
            $table->unsignedBigInteger('supplierid_id')->nullable(false);
            $table->foreign('supplierid_id', 'supplierid_fk_10397204')->references('id')->on('user_infos');
        });
    }
}