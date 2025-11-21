<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLeadsModulesTable extends Migration
{
    public function up()
    {
        Schema::table('leads_modules', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_to_id')->nullable();
            $table->foreign('assigned_to_id', 'assigned_to_fk_10765947')->references('id')->on('users');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id', 'service_fk_10765959')->references('id')->on('services');
        });
    }
}
