<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionChecklistInspectionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspection_checklist_inspection_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            # Create inspection_checklist_id and inspection_item_id unsigned bigIntegers
            $table->bigInteger('checklist_id')->unsigned();
            $table->bigInteger('inspection_item_id')->unsigned();

            # Make the above foreign keys linking the inspection_checklists and inspection_items tables together
            $table->foreign('checklist_id')->references('id')->on('inspection_checklists');
            $table->foreign('inspection_item_id')->references('id')->on('inspection_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspection_checklist_inspection_item');
    }
}
