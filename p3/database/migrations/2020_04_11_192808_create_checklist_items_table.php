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
            $table->bigIncrements('id');

            # Checklist Item Number TINYINT
            $table->tinyInteger('item_number');

            # Checklist Item Name VARCHAR
            $table->string('item_name');

            # Checklist Item Included BOOLEAN
            $table->boolean('included');

            # Checklist Item Page Reference SMALLINT
            $table->smallInteger('page_reference');

            # Checklist Item Comments TEXT
            $table->text('comments');
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
