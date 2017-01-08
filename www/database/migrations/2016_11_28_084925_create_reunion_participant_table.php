<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReunionParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunion_participant', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('reunion_id')->unsigned();
            $table->foreign('reunion_id')
            ->references('id')
            ->on('reunion')
            ->onDelete('cascade');

            $table->char("nom");
            $table->enum("type",["present", "absent", "secretaire"]);
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
        Schema::dropIfExists("reunion_participant");
    }
}
