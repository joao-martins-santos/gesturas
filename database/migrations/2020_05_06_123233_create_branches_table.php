<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('type');
            $table->string('protocol')->nullable();
            $table->string('bind')->nullable();
            $table->string('context')->nullable();
            $table->string('disallow')->nullable();
            $table->string('allow')->nullable();
            $table->string('aors')->nullable();
            $table->string('auth')->nullable();
            $table->string('max_contacts')->nullable();
            $table->string('auth_type')->nullable();
            $table->string('password')->nullable();
            $table->string('username')->nullable();
            $table->string('contact')->nullable();
            $table->SoftDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}



