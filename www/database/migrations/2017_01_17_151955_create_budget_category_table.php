<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_category', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('budget_id')->unsigned();
            $table->foreign('budget_id')
            ->references('id')
            ->on('budget')
            ->onDelete('cascade');

            $table->mediumText('name');
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
        Schema::dropIfExists('budget_category');
    }
}
