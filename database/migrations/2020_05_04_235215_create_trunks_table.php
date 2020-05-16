<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrunksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trunks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type');
            $table->string('outbound_auth')->nullable();
            $table->string('server_uri')->nullable();
            $table->string('client_uri')->nullable();
            $table->string('context')->nullable();
            $table->string('disallow')->nullable();
            $table->string('allow')->nullable();
            $table->string('aors')->nullable();
            $table->string('endpoint')->nullable();
            $table->string('match')->nullable();
            $table->string('auth_type')->nullable();
            $table->string('password')->nullable();
            $table->string('username')->nullable();
            $table->string('protocol')->nullable();
            $table->string('bind')->nullable();
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
        Schema::dropIfExists('trunks');
    }
}
