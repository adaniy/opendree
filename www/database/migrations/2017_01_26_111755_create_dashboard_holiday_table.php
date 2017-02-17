<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardHolidayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_holiday', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->foreign('agent_id')
                ->references('id')
                ->on('agent')
                ->onDelete('cascade');

            $table->date('debut');
            $table->date('fin');
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
        Schema::dropIfExists('dashboard_holiday');
    }
}
