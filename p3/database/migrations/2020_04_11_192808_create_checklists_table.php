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
