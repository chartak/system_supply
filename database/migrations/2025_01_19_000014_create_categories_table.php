<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cpv', 15)->nullable(false)->unique();
            $table->string('name')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}