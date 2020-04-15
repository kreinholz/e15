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
            $table->bigInteger('inspector')->unsigned();
            
            # Inspector FOREIGN KEY from users table
            $table->foreign('inspector')->references('id')->on('users');

            # Inspection due date DATE
            $table->date('inspection_date');

            # Instantiate an unsigned new column to act as a foreign key
            # See https://github.com/susanBuck/e15-spring20/issues/38
            $table->bigInteger('checklist')->unsigned();

            # Checklist FOREIGN KEY from checklists table
            $table->foreign('checklist')->references('id')->on('checklists');
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
