<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistChecklistItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_checklist_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            # Create checklist_id and checklist_item_id unsigned bigIntegers
            $table->bigInteger('checklist_id')->unsigned();
            $table->bigInteger('checklist_item_id')->unsigned();

            # Make the above foreign keys linking the checklists and checklist_items tables together
            $table->foreign('checklist_id')->references('id')->on('checklists');
            $table->foreign('checklist_item_id')->references('id')->on('checklist_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklist_checklist_item');
    }
}
