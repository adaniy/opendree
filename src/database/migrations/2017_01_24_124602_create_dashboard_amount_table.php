<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_amount', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('dashboard_id')->unsigned();
            $table->foreign('dashboard_id')
                ->references('id')
                ->on('dashboard')
                ->onDelete('cascade');
            
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('dashboard_categories')
                ->onDelete('cascade');

            
            $table->bigInteger('amount');
            
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
        Schema::dropIfExists('dashboard_amount');
    }
}
