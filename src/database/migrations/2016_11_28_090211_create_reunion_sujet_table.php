<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReunionSujetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunion_sujet', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('reunion_id')->unsigned();
            $table->foreign('reunion_id')
            ->references('id')
            ->on('reunion')
            ->onDelete('cascade');
            
            $table->string("sujet");
            $table->text("observation");
            $table->text("action");

            $table->softDeletes();
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
        Schema::dropIfExists("reunion_sujet");
    }
}
