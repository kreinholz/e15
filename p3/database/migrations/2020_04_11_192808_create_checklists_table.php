<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            # Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column
            $table->id();

            # Adds nullable created_at and updated_at TIMESTAMP equivalent columns with precision (total digits)
            $table->timestamps();

            # Add a title for this particular checklist, e.g. "Checklist for Reviewing the Rail Transit Agency Safety Plan"
            $table->string('title');

            # TO DO: Create a MANY-TO-MANY relationship between checklists and checklist_items
            # Currently, we have a ONE-TO-MANY relationship between checklist_items and checklists
            # but we actually want it to work both ways.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
