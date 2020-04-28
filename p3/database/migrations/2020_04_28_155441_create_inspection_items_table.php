<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_items', function (Blueprint $table) {
            # Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->id();

            # Checklist Item Number TINYINT
            $table->tinyInteger('item_number');

            # Checklist Item Name VARCHAR
            $table->string('item_name');

            # Checklist Item Plan Requirement VARCHAR
            $table->string('plan_requirement');

            # Checklist Item Included BOOLEAN
            $table->boolean('included')->nullable();

            # Checklist Item Page Reference SMALLINT
            $table->smallInteger('page_reference')->nullable();

            # Checklist Item Comments TEXT
            $table->text('comments')->nullable();

            # Laravel expects this by default, so we either have to include it or deliberately
            # set it to false in the model. Ref: https://laravel.com/docs/5.6/eloquent#eloquent-model-conventions
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
        Schema::dropIfExists('inspection_items');
    }
}
