<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            # Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->id();

            # Adds nullable created_at and updated_at TIMESTAMP equivalent columns with precision (total digits)
            $table->timestamps();

            # Rail Transit Agency VARCHAR
            $table->string('rail_transit_agency');

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
            $table->bigInteger('inspector_id')->unsigned();
            
            # Inspector FOREIGN KEY from users table
            $table->foreign('inspector_id')->references('id')->on('users');

            # Inspection due date DATE
            $table->date('inspection_date');

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
            $table->bigInteger('checklist_id')->unsigned();

            # Checklist FOREIGN KEY from checklists table
            $table->foreign('checklist_id')->references('id')->on('checklists');

            # TO DO: The above might need modification...we want the checklist_items associated
            # with a given checklist to be COPIED over to this table, not linked, because we
            # only want edits to checklist_items to be reflected in an inspection, not in a base
            # checklist.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
}
