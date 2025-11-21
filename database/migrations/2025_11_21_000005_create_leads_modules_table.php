<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsModulesTable extends Migration
{
    public function up()
    {
        Schema::create('leads_modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('remarks_by_telecaller')->nullable();
            $table->datetime('last_call_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
