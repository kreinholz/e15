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

            # Inspection date DATE
            $table->date('inspection_date');

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
            $table->bigInteger('checklist_id')->unsigned();

            # Checklist FOREIGN KEY from inspection_cls (inspection checklists) table
            $table->foreign('checklist_id')->references('id')->on('inspection_cls');

            # Inspection Completed BOOLEAN
            $table->boolean('completed');
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
