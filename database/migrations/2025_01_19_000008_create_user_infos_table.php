<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company');
            $table->string('company_email');
            $table->string('phone', 15);
            $table->string('address');
            $table->string('bank_name');
            $table->bigInteger('bank_account_number');
            $table->string('type');
            $table->string('tax_code')->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}