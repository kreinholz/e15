<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_items', function (Blueprint $table) {
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

            # Commented out the below because I don't believe we want a foreign key or ONE-TO-MANY relationship
            # linking each ChecklistItem to a Checklist. Rather, we want to be able to link Checklist Items to
            # any number of Checklists (MANY-TO-MANY), and moreover, to copy mutatable Checklist Items over to
            # Inspections while preserving the original Checklist Items for copying to new Inspections.

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
#            $table->bigInteger('checklist_id')->unsigned();

            # Add foreign key associating checklist items with a checklist
            # See https://github.com/susanBuck/e15-spring20/issues/38
#            $table->foreign('checklist_id')->references('id')->on('checklists');

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
        Schema::dropIfExists('checklist_items');
    }
}
