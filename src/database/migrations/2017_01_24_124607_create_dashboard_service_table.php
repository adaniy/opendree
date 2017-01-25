<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_service', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('dashboard_id')->unsigned();
            $table->foreign('dashboard_id')
                ->references('id')
                ->on('dashboard')
                ->onDelete('cascade');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')
                ->references('id')
                ->on('service')
                ->onDelete('cascade');

            $table->bigInteger('agents');
            $table->bigInteger('holidays');
            $table->bigInteger('hours');

            $table->date('date');
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
        Schema::dropIfExists('dashboard_service');
    }
}
