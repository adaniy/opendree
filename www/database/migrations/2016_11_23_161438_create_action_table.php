<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('alert',[0,1])->nullable();
            $table->string("nom")->nullable();
            $table->text("description")->nullable();
            $table->date('date_creation')->nullable();
            $table->date('date_butoire')->nullable();
            $table->date('date_realisation')->nullable();
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
        Schema::dropIfExists('action');
    }
}
