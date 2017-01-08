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
            $table->enum('alert',[0,1]);
            $table->integer('alertStart')->unsigned();
            $table->string("nom");
            $table->enum("realise",[0,1]);
            $table->date('date_creation');
            $table->date('date_butoire');
            $table->date('date_realisation');
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
